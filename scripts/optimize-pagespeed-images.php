<?php

// Regenerate small static image variants from repository originals.
$variants = [
    ['public/images/story_spices-optimized.webp', 'public/images/story_spices-420.webp', 420, 66],
    ['public/images/story_spices-optimized.webp', 'public/images/story_spices-560-optimized.webp', 560, 60],
    ['public/images/product_hero-320.webp', 'public/images/product_hero-200.webp', 200, 70],
];
foreach ($variants as [$source, $target, $width, $quality]) {
    $image = imagecreatefromwebp($source);
    if (!$image) throw new RuntimeException("Cannot read {$source}");
    $height = (int) round(imagesy($image) * $width / imagesx($image));
    $resized = imagecreatetruecolor($width, $height);
    imagealphablending($resized, false);
    imagesavealpha($resized, true);
    imagecopyresampled($resized, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
    if (!imagewebp($resized, $target, $quality)) throw new RuntimeException("Cannot write {$target}");
}
