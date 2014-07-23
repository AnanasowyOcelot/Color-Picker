<?php
function rgb2html($r, $g, $b)
{
    if (is_array($r) && sizeof($r) == 3)


        $r = intval($r);
    $g = intval($g);
    $b = intval($b);

    $r = dechex($r);
    $g = dechex($g);
    $b = dechex($b);

    $color = (strlen($r) < 2 ? '0' : '') . $r;
    $color .= (strlen($g) < 2 ? '0' : '') . $g;
    $color .= (strlen($b) < 2 ? '0' : '') . $b;
    return '#' . $color;
}

$colors = [];

$im = imagecreatefromjpeg("spring-snowdrops-wallpaper-flowers-32897799-1920-1080.jpg");
//$im = imagecreatefrompng("piq_22677_400x400.png");

$answerToEverything = 15;

list($width, $height) = getimagesize("spring-snowdrops-wallpaper-flowers-32897799-1920-1080.jpg");
$image_p = imagecreatetruecolor($answerToEverything, $answerToEverything);

imagecopyresampled($image_p, $im, 0, 0, 0, 0, $answerToEverything, $answerToEverything, $width, $height);
//imagefilter($image_p, IMG_FILTER_PIXELATE, 2);

$im = $image_p;

for ($y = 0; $y < imagesy($im); $y++) {
    for ($x = 0; $x < imagesx($im); $x++) {
        $rgb = imagecolorat($im, $x, $y);

        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;

        $color = rgb2html($r, $g, $b);

        if (!array_key_exists($color, $colors)) {
            $colors[$color] = 1;
        } else if (array_key_exists($color, $colors)) {
            $colors[$color] = $colors[$color] + 1;
        }

    }
}

arsort($colors);
$colors = array_keys($colors);

if (($key = array_search('#000000', $colors)) !== false) {
    array_splice($colors, $key, 1);
}

for ($i = 0; $i < $answerToEverything * $answerToEverything; $i++) {
    if (isset($colors[$i])) {
        echo '<div style="height:50px; width:50px; background-color:' . $colors[$i] . '; display: inline-block;"></div>';

    }

}




