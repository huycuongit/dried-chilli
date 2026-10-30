<?php
// Standalone routing-map tests; run with: php tests/page-path-map.php
require __DIR__ . '/../app/Support/PagePathMap.php';
use App\Support\PagePathMap;
$count = 0;
function verifyPath($condition, $message) {
    global $count;
    if (!$condition) { throw new RuntimeException($message); }
    $count++;
}
function rejectsPath($map, $input, $message) {
    try { $map->updated($input); } catch (InvalidArgumentException $e) { verifyPath(true, $message); return; }
    verifyPath(false, $message);
}
$map = new PagePathMap();
verifyPath($map->current('home', 'vi') === '', 'Default home');
verifyPath($map->current('services', 'vi') === 'services', 'Existing URLs preserved');
$state = $map->updated(['services' => ['vi' => 'dich-vu'], 'news' => ['vi' => 'tin-tuc'], 'projects' => ['vi' => 'du-an']]);
$map = new PagePathMap($state);
verifyPath($map->current('services', 'en') === 'services', 'Languages are independent');
foreach (['dich-vu' => 'services', 'tin-tuc' => 'news', 'du-an' => 'projects'] as $path => $page) {
    verifyPath($map->resolve($path, 'vi') === $page, 'Custom URL resolves');
    verifyPath($map->resolve($page, 'vi') === $page, 'Default URL remains an alias');
}
verifyPath($map->resolve('dich-vu', 'en') === null, 'No cross-language aliases');
verifyPath($map->resolve('unknown', 'vi') === null, 'Unknown URL must 404');
$map = new PagePathMap($map->updated(['services' => ['vi' => 'thiet-ke-web']]));
verifyPath($map->resolve('dich-vu', 'vi') === 'services', 'Earlier custom URL remains an alias');
verifyPath($map->current('services', 'vi') === 'thiet-ke-web', 'Alias points to newest path');
rejectsPath($map, ['news' => ['vi' => 'dich-vu']], 'Cannot claim another page history');
rejectsPath($map, ['news' => ['vi' => 'services']], 'Cannot claim built-in path');
rejectsPath($map, ['news' => ['vi' => 'same'], 'projects' => ['vi' => 'same']], 'Duplicate new paths rejected');
foreach (['dịch-vụ', '/dich-vu', 'dich/vu', '../news', 'https://example.com', 'UPPER', 'a--b', 'a?', 'a#b', '-a', 'a-', str_repeat('a', 101)] as $bad) {
    rejectsPath($map, ['services' => ['vi' => $bad]], 'Invalid path rejected: ' . $bad);
}
$map = new PagePathMap($map->updated(['home' => ['vi' => 'trang-chu']]));
verifyPath($map->resolve('', 'vi') === 'home', 'Old locale root remains home');
verifyPath($map->current('home', 'vi') === 'trang-chu', 'Custom home path');
$map = new PagePathMap($map->updated(['home' => ['vi' => null], 'services' => ['vi' => null]]));
verifyPath($map->current('home', 'vi') === '', 'Empty home restores locale root');
verifyPath($map->current('services', 'vi') === 'services', 'Empty service restores default');
verifyPath($map->resolve('trang-chu', 'vi') === 'home', 'Custom home remains an alias after reset');
verifyPath($map->resolve('thiet-ke-web', 'vi') === 'services', 'Custom service remains alias after reset');
echo "Passed {$count} page path checks.\n";
