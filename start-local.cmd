@echo off
setlocal
title Sanbada - local website
cd /d "%~dp0public"
set "APP_URL=http://127.0.0.1:8124"
echo Start MySQL in MAMP before using this window.
echo Website: http://127.0.0.1:8124/ru
echo Admin:   http://127.0.0.1:8124/admin/login
echo Keep this window open while using the local website. Press Ctrl+C to stop.
php -d upload_max_filesize=20M -d post_max_size=256M -d max_file_uploads=30 -S 127.0.0.1:8124 ..\vendor\laravel\framework\src\Illuminate\Foundation\resources\server.php
pause
