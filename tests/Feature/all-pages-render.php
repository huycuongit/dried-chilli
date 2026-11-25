<?php

require __DIR__ . '/../../vendor/autoload.php';
$app = require_once __DIR__ . '/../../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$urls = [
    '/' => 'Home',
    '/shop' => 'Shop',
    '/shop/crispy-shrimp-chili-oil' => 'Product',
    '/about-us' => 'About',
    '/our-legacy' => 'Legacy',
    '/contact' => 'Contact',
    '/cart' => 'Cart',
    '/shipping-refunds' => 'Shipping',
    '/privacy-policy' => 'Privacy',
    '/terms-of-service' => 'Terms',
    '/faq' => 'FAQ'
];

$all_ok = true;
foreach ($urls as $url => $name) {
    $req = Illuminate\Http\Request::create($url, 'GET');
    $res = $kernel->handle($req);
    $status = $res->getStatusCode();
    $content = $res->getContent();
    $has_header = str_contains($content, 'jojo-site-header');
    $has_footer = str_contains($content, 'jojo-footer');
    if ($status !== 200 || !$has_header || !$has_footer) {
        $all_ok = false;
        echo "FAIL: $name ($url) -> status: $status, header: $has_header, footer: $has_footer\n";
    } else {
        echo "PASS: $name ($url) -> 200 OK\n";
    }
}

exit($all_ok ? 0 : 1);
