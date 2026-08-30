<?php

namespace App\Services;

use App\Models\Jadwal;
use App\Models\Pemesanan;
use App\Models\Penumpang;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ContentBasedFilteringService
{
    /**
     * Get content-based recommended schedules for a passenger.
     * If passenger has no booking history (new account), returns empty collection.
     *
     * @param Penumpang|null $penumpang
     * @param int $limit
     * @return Collection
     */
    public function getRecommendations(?Penumpang $penumpang, int $limit = 6): Collection
    {
        if (!$penumpang) {
            return collect([]);
        }

        // Fetch user's booking history (excluding canceled trips)
        $historyPemesanans = Pemesanan::with(['jadwal.armada'])
            ->where('id_penumpang', $penumpang->id_penumpang)
            ->where('status_perjalanan', '!=', 'Batal')
            ->get();

        // Rule: If new account / no history, return empty collection
        if ($historyPemesanans->isEmpty()) {
            return collect([]);
        }

        // Extract user profile features
        $routeCounts = [];
        $originCounts = [];
        $destCounts = [];
        $hours = [];
        $totalBookings = $historyPemesanans->count();

        foreach ($historyPemesanans as $p) {
            $jadwal = $p->jadwal;
            if (!$jadwal) {
                continue;
            }

            // Route key
            $routeKey = trim($jadwal->asal) . '->' . trim($jadwal->tujuan);
            $routeCounts[$routeKey] = ($routeCounts[$routeKey] ?? 0) + 1;

            $originCounts[trim($jadwal->asal)] = ($originCounts[trim($jadwal->asal)] ?? 0) + 1;
            $destCounts[trim($jadwal->tujuan)] = ($destCounts[trim($jadwal->tujuan)] ?? 0) + 1;

            // Time / Hour
            if ($jadwal->jam) {
                try {
                    $hours[] = (float) Carbon::parse($jadwal->jam)->hour;
                } catch (\Exception $e) {
                    // fallback if invalid time
                }
            }
        }

        if ($totalBookings === 0) {
            return collect([]);
        }

        $avgHour = !empty($hours) ? (array_sum($hours) / count($hours)) : 12.0;

        // Fetch candidate future schedules (departure date & time must be in the future, armada must be active)
        $candidateJadwals = Jadwal::with(['armada', 'sopir'])
            ->armadaAktif()
            ->mendatang()
            ->get();

        $scoredJadwals = collect();

        foreach ($candidateJadwals as $candidate) {
            // 1. Route Similarity (Weight: 0.60)
            $candRouteKey = trim($candidate->asal) . '->' . trim($candidate->tujuan);
            if (isset($routeCounts[$candRouteKey])) {
                $simRoute = $routeCounts[$candRouteKey] / $totalBookings;
            } else {
                $origMatch = ($originCounts[trim($candidate->asal)] ?? 0) / $totalBookings;
                $destMatch = ($destCounts[trim($candidate->tujuan)] ?? 0) / $totalBookings;
                $simRoute = 0.5 * ($origMatch + $destMatch);
            }

            // 2. Hour / Schedule Similarity (Weight: 0.40)
            $candHour = 12.0;
            if ($candidate->jam) {
                try {
                    $candHour = (float) Carbon::parse($candidate->jam)->hour;
                } catch (\Exception $e) {
                }
            }
            $hourDiff = abs($candHour - $avgHour);
            $simHour = max(0.0, 1.0 - ($hourDiff / 12.0));

            // Final Composite CBF Score (Route: 0.60, Hour: 0.40)
            $totalScore = (0.60 * $simRoute) + (0.40 * $simHour);
            $matchPercentage = min(100, max(0, (int) round($totalScore * 100)));

            // Rule: Filter recommendations to only include match percentage >= 50%
            if ($matchPercentage >= 50) {
                $candidate->cbf_score = round($totalScore, 4);
                $candidate->match_percentage = $matchPercentage;
                $scoredJadwals->push($candidate);
            }
        }

        // Sort by CBF score descending, then date/time ascending
        return $scoredJadwals
            ->sortByDesc('cbf_score')
            ->values()
            ->take($limit);
    }
}
