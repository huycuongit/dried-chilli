# FEB Website & CMS

Hệ thống cài đặt dữ liệu cho lịch học, học viên.

### Product image upload limits

For local development on Windows, start the PHP server with `powershell -File scripts/serve-local.ps1`. This sets `upload_max_filesize=5M`, `post_max_size=32M`, and `max_file_uploads=20` for that server process. Restart an existing server after changing these settings.

For PHP-FPM/CGI, `public/.user.ini` requests the same limits when per-directory configuration is enabled. Apache mod_php or environments that disable `.user.ini` need the equivalent PHP server configuration. Set the reverse proxy or web server request-body limit to at least 32 MB as well, then reload the relevant service. PHP settings and proxy limits depend on the hosting environment; verify the effective values after deployment.

### Frontend asset caching (Nginx)

For Nginx deployments, the example `deploy/nginx/static-assets.conf` can be included inside the existing HTTPS `server` block to enable static asset caching and gzip. Review it against existing location rules and any CDN policy first, then run `nginx -t` and reload Nginx. The application document root must point to `public/`. Apache installations can use the rules already in `public/.htaccess` when `mod_expires` and `mod_deflate` are enabled. Verify live response headers after deployment; `.htaccess` does not configure Nginx.

### PageSpeed: responsive images and static caching

After deploying the code, create variants for the existing public page images:

```sh
php artisan images:generate-page-variants
php artisan view:clear
```

The command can be rerun; it preserves originals and reports files it cannot process. Ensure the public storage disk is writable and `public/storage` points to `storage/app/public`. New page-image uploads generate variants automatically. Until variants exist, the original image remains in use.

For nginx, include `deploy/nginx/static-assets.conf` in the existing HTTPS server block and check `nginx -t` before reloading. For Apache, enable `mod_expires`, `mod_headers` and `mod_deflate` and allow the directives in `public/.htaccess`. Existing CDN or server cache headers may need adjustment. Re-run both mobile and desktop PageSpeed after deployment; results depend on the live server and network.

The nginx include also redirects three legacy `/assets/dried-chilli/nafu-*` URLs to their current assets. After updating it on an existing server, run `nginx -t` and reload nginx; static-file rules otherwise may return 404 before Laravel can redirect these legacy URLs. Run `php artisan migrate --force` to update matching saved system settings.

### API access and retired bundles

The unauthenticated `/api/users`, `/api/users/{id}`, and `PUT /api/orders/{id}/status` endpoints are retired. Manage administrators and order statuses through the authenticated admin interface. `GET /api/orders` requires a signed-in customer session. Bundle creation and `/api/cart/add-bundle` are retired; historical bundle records remain available, and existing bundle cart items must be removed before checkout. Shipping under the free-shipping threshold is confirmed separately and is not included in the displayed checkout total.

### Cart and checkout API errors

Cart, coupon and checkout requests return JSON errors. Invalid request fields return HTTP 422 with `message` and `errors` keyed by field. Business failures such as insufficient stock, unavailable options or invalid coupons return HTTP 422 with `message` (stock responses may also include `available`). An item belonging to a different cart returns HTTP 404. Unexpected server errors are reported to the application log and return HTTP 500 with a generic `message`; payment-provider availability errors may return HTTP 503. Clients should show the first field error when present, otherwise `message`, and preserve the cart so customers can correct the issue.

### Checkout, stock and refunds

Deploy the code and run `php artisan migrate --force`. The checkout and cart APIs use the Laravel web session and CSRF protection: clients must send the session cookie, `X-CSRF-TOKEN`, and their `Session-Id`. Begin with `POST /api/checkout/session`; the returned `checkoutToken` is sent as `Checkout-Token` along with `expected_total` when placing a COD order or starting an online payment. Sessions expire after 15 minutes. An online payment attempt can expire sooner when a cart sale price is due to change. Expired or stale totals must be reviewed and checkout restarted. Bank transfer is temporarily unavailable until its payment-confirmation and stock flow is implemented; COD and enabled Stripe/PayPal remain available.

Adding items and starting online checkout do not reserve inventory. On payment confirmation, inventory is checked and deducted inside a database transaction; unsuccessful fulfillment creates a pending refund and retains the cart. In a race, the first confirmation processed under the database lock wins. Provider webhook delivery is asynchronous, so this does not guarantee that the provider's earliest payment timestamp is always processed first. COD is committed at order confirmation.

A refund is marked complete only when Stripe or PayPal confirms it. Pending and failed refunds are visible on the admin Orders page; investigate provider failures and application logs. The Stripe webhook must be configured, and the server must run Laravel's scheduler every minute for expiration, PayPal reconciliation and refund retry. For example, configure cron for the deployment user:

```cron
* * * * * cd /path/to/dried-chilli && php artisan schedule:run >> /dev/null 2>&1
```

Run `php artisan schedule:list` to confirm registration. Test Stripe and PayPal in sandbox, including delayed webhooks, capture timeouts, refund failures and retries, before enabling real payments. Attempts created before this migration have no checkout expiry and are not retroactively expired.

