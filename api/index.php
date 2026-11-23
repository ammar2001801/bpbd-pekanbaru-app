<?php

// Buat direktori sementara di /tmp untuk penyimpanan cache & views (karena file system Vercel bersifat read-only)
$dirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Teruskan penanganan request ke public/index.php Laravel
require __DIR__ . '/../public/index.php';
