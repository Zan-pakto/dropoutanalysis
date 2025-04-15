<?php
// List of states that need images
$states = [
    'maharashtra',
    'tamilnadu',
    'up',
    'rajasthan',
    'mp'
];

// Create images directory if it doesn't exist
if (!file_exists('img')) {
    mkdir('img', 0777, true);
}

// Generate placeholder images for each state
foreach ($states as $state) {
    $imagePath = "img/{$state}.png";
    
    // Check if image already exists
    if (file_exists($imagePath)) {
        echo "Image for {$state} already exists. Skipping.\n";
        continue;
    }
    
    // Create a new image
    $width = 800;
    $height = 600;
    $image = imagecreatetruecolor($width, $height);
    
    // Set background color (dark blue)
    $bgColor = imagecolorallocate($image, 8, 20, 27);
    imagefill($image, 0, 0, $bgColor);
    
    // Add state name
    $textColor = imagecolorallocate($image, 255, 255, 255);
    $stateName = ucwords(str_replace('_', ' ', $state));
    $fontSize = 5;
    $textWidth = strlen($stateName) * imagefontwidth($fontSize);
    $textHeight = imagefontheight($fontSize);
    $x = ($width - $textWidth) / 2;
    $y = ($height - $textHeight) / 2;
    imagestring($image, $fontSize, $x, $y, $stateName, $textColor);
    
    // Save the image
    imagepng($image, $imagePath);
    imagedestroy($image);
    
    echo "Generated image for {$state}.\n";
}

echo "All images generated successfully.\n";
?> 