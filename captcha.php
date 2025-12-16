<?php
session_start();

$characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
$captcha = '';
for ($i = 0; $i < 6; $i++) {
    $captcha .= $characters[rand(0, strlen($characters) - 1)];
}

$_SESSION['captcha_code'] = password_hash($captcha, PASSWORD_DEFAULT);
$_SESSION['captcha_time'] = time();

$width = 160;
$height = 50;
$image = imagecreatetruecolor($width, $height);

$bg = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 30, 30, 30);
$noise_color = imagecolorallocate($image, 180, 180, 180);

imagefilledrectangle($image, 0, 0, $width, $height, $bg);

for ($i = 0; $i < 6; $i++) {
    imageline(
        $image,
        rand(0, $width),
        rand(0, $height),
        rand(0, $width),
        rand(0, $height),
        $noise_color
    );
}

for ($i = 0; $i < 300; $i++) {
    imagesetpixel(
        $image,
        rand(0, $width),
        rand(0, $height),
        $noise_color
    );
}

$font = __DIR__ . '/font/ARIAL.TTF';
$font_size = 22;

$x = 15;
for ($i = 0; $i < strlen($captcha); $i++) {
    imagettftext(
        $image,
        $font_size,
        rand(-15, 15),
        $x,
        rand(30, 40),
        $text_color,
        $font,
        $captcha[$i]
    );
    $x += 22;
}

header('Content-Type: image/png');
imagepng($image);
