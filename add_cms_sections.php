<?php
$configPath = config_path('nafu-home-content.json');
$content = json_decode(file_get_contents($configPath), true);

$content['About Us'] = [
    'page_about_title' => ['value' => 'Who We Are', 'label' => 'Hero Title'],
    'page_about_desc' => ['value' => 'A small collective of spice enthusiasts dedicated to bringing you the most authentic flavors from around the globe.', 'label' => 'Hero Description'],
    'page_about_mission_title' => ['value' => 'Our Mission', 'label' => 'Mission Title'],
    'page_about_mission_text' => ['value' => 'To source, blend, and deliver the finest spices while supporting sustainable farming practices and empowering local communities.', 'label' => 'Mission Text']
];

$content['Our Legacy'] = [
    'page_legacy_title' => ['value' => 'Generations of Flavor', 'label' => 'Hero Title'],
    'page_legacy_desc' => ['value' => 'Rooted in heritage, our spices carry the legacy of ancient trade routes and secret family recipes passed down through generations.', 'label' => 'Hero Description'],
    'page_legacy_story_title' => ['value' => 'Where It All Began', 'label' => 'Story Title'],
    'page_legacy_story_text' => ['value' => 'Decades ago, our founders started with a single market stall and a passion for authentic taste. Today, that same passion drives everything we do.', 'label' => 'Story Text']
];

file_put_contents($configPath, json_encode($content, JSON_PRETTY_PRINT));
echo "CMS sections added successfully!";
