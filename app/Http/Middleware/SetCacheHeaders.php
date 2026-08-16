<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCacheHeaders
{
    /**
     * Handle an incoming request and attach browser caching headers (ETag / Cache-Control).
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // Only cache GET requests with successful responses (200 OK)
        if (!$request->isMethod('GET') || $response->getStatusCode() !== 200) {
            return $response;
        }

        // Do not cache responses that contain session flash messages (success, error, status, info)
        if ($request->hasSession()) {
            $session = $request->session();
            if ($session->has('success') || $session->has('error') || $session->has('status') || $session->has('info')) {
                $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, private');
                return $response;
            }
        }

        $content = $response->getContent();
        if ($content === false || $content === '') {
            return $response;
        }

        // Generate ETag based on response body content MD5 hash
        $etag = '"' . md5($content) . '"';
        $response->headers->set('ETag', $etag);
        $response->headers->set('Cache-Control', 'private, no-cache, must-revalidate');

        // Check if browser sent If-None-Match matching current ETag
        $ifNoneMatch = $request->header('If-None-Match');
        if ($ifNoneMatch !== null && trim($ifNoneMatch) === $etag) {
            $notModifiedResponse = response('', 304);
            $notModifiedResponse->headers->set('ETag', $etag);
            $notModifiedResponse->headers->set('Cache-Control', 'private, no-cache, must-revalidate');
            return $notModifiedResponse;
        }

        return $response;
    }
}
