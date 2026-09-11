<?php

// Run with PHP GD enabled: php -d extension=gd scripts/optimize-images.php
foreach (['maritime-hero', 'storage-terminal', 'logistics', 'detra-logo', 'energy-team', 'fuel-detail', 'lubricants-detail', 'terminal-night'] as $name) {
    $source = imagecreatefrompng(__DIR__.'/../public/images/'.$name.'.png');
    imagewebp($source, __DIR__.'/../public/images/'.$name.'.webp', 86);
    imagedestroy($source);
}
