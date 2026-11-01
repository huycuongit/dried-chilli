param([string]$PhpPath = 'php')

# Start the local development server with the same upload limits as PHP-FPM.
$version = & $PhpPath -r 'echo PHP_MAJOR_VERSION . "." . PHP_MINOR_VERSION;'
if ($LASTEXITCODE -ne 0 -or $version -notmatch '^\d+\.\d+$' -or [version]$version -lt [version]'8.3') {
    Write-Error "PHP 8.3 or newer is required. Specify its executable with -PhpPath; detected: $version"
    exit 1
}
Set-Location (Join-Path $PSScriptRoot '..')
& $PhpPath -d upload_max_filesize=5M -d post_max_size=32M -d max_file_uploads=20 -S 127.0.0.1:8000 -t public server.php
exit $LASTEXITCODE
