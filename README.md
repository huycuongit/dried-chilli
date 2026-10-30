# FEB Website & CMS

Hệ thống cài đặt dữ liệu cho lịch học, học viên.

### Product image upload limits

For local development on Windows, start the PHP server with `powershell -File scripts/serve-local.ps1`. This sets `upload_max_filesize=5M`, `post_max_size=32M`, and `max_file_uploads=20` for that server process. Restart an existing server after changing these settings.

For PHP-FPM/CGI, `public/.user.ini` requests the same limits when per-directory configuration is enabled. Apache mod_php or environments that disable `.user.ini` need the equivalent PHP server configuration. Set the reverse proxy or web server request-body limit to at least 32 MB as well, then reload the relevant service. PHP settings and proxy limits depend on the hosting environment; verify the effective values after deployment.

### Frontend asset caching (Nginx)

For Nginx deployments, the example `deploy/nginx/static-assets.conf` can be included inside the existing HTTPS `server` block to enable static asset caching and gzip. Review it against existing location rules and any CDN policy first, then run `nginx -t` and reload Nginx. The application document root must point to `public/`. Apache installations can use the rules already in `public/.htaccess` when `mod_expires` and `mod_deflate` are enabled. Verify live response headers after deployment; `.htaccess` does not configure Nginx.
