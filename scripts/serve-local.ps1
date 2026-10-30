# Start the local development server with the same upload limits as PHP-FPM.
Set-Location (Join-Path $PSScriptRoot '..')
php -d upload_max_filesize=5M -d post_max_size=32M -d max_file_uploads=20 -S 127.0.0.1:8000 server.php
