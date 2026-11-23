<?php

$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

// Buat direktori sementara di /tmp untuk penyimpanan cache, sessions, views, logs
$dirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/storage/fonts',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Setup SQLite database di /tmp agar bisa dibaca dan ditulis (writable)
$sourceDb = __DIR__ . '/../database/database.sqlite';
$targetDb = '/tmp/database.sqlite';

if (file_exists($sourceDb)) {
    if (!file_exists($targetDb) || filesize($targetDb) < 10000 || filesize($targetDb) < filesize($sourceDb)) {
        copy($sourceDb, $targetDb);
    }
} elseif (!file_exists($targetDb)) {
    touch($targetDb);
}

$_ENV['DB_DATABASE'] = $targetDb;
$_SERVER['DB_DATABASE'] = $targetDb;
putenv("DB_DATABASE={$targetDb}");

// Teruskan penanganan request ke public/index.php Laravel
require __DIR__ . '/../public/index.php';
