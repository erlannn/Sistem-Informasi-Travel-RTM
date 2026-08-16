<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// 1. Create writable storage directories in Vercel's /tmp environment
$storageDirs = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/bootstrap/cache',
    '/tmp/storage/logs',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// 2. Set environment variables for storage & view compilation
putenv('APP_STORAGE=/tmp/storage');
$_ENV['APP_STORAGE'] = '/tmp/storage';
$_SERVER['APP_STORAGE'] = '/tmp/storage';

putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';

define('LARAVEL_START', microtime(true));

// 3. Register Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

// 4. Bootstrap Laravel Application
/** @var Application $app */
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 5. Explicitly instruct Laravel to use /tmp/storage for writable files on Vercel Serverless
$app->useStoragePath('/tmp/storage');

// 6. Handle HTTP Request
$app->handleRequest(Request::capture());
