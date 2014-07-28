<?php
function rgb2html($r, $g, $b)
{
    if (is_array($r) && sizeof($r) == 3)


        $r = intval($r);
    $g = intval($g);
    $b = intval($b);

    $arr = [$r, $g, $b];

    sort($arr);

    $median = $arr[1];


    $highestVal = max($r, $g, $b);
    $lowestVal = min($r, $g, $b);


    if ($highestVal != 0) {
        $newMedian = (255 * $median) / $highestVal;
    } else {
        $newMedian = $median;
    }

    $newMedian = 100 * round($newMedian / 100);

    $nr = 0;
    $ng = 0;
    $nb = 0;

    if ($r == $highestVal) {
        $nr = 255;
    } else if ($g == $highestVal) {
        $ng = 255;
    } else if ($b == $highestVal) {
        $nb = 255;
    }

    if ($r == $lowestVal) {
        $nr = 0;
    } else if ($g == $lowestVal) {
        $ng = 0;
    } else if ($b == $lowestVal) {
        $nb = 0;
    }
    if ($r == $median) {
        $nr = $newMedian;
    } else if ($g == $median) {
        $ng = $newMedian;
    } else if ($b == $median) {
        $nb = $newMedian;
    }

    $r = dechex($nr);
    $g = dechex($ng);
    $b = dechex($nb);

    $color = (strlen($r) < 2 ? '0' : '') . $r;
    $color .= (strlen($g) < 2 ? '0' : '') . $g;
    $color .= (strlen($b) < 2 ? '0' : '') . $b;

  
    if(strlen($color) == 6){
        return '#' . $color;
    }else{
        return "#FFFFFF";
    }

};

$urls = ['spring-snowdrops-wallpaper-flowers-32897799-1920-1080.jpg', 'uRBtadp.jpg', 'orange_cat_2_by_francescadelfino-d6rmo99.jpg', 'Meaning-of-morning-glory-flower.jpg'];
$url = 'uRBtadp.jpg';

foreach ($urls as $url) {

    echo '<img src="', $url, '" style="height:200; width:200;"><br/>';

    $colors = [];

    $im = imagecreatefromjpeg($url);

    $answerToEverything = 15;

    list($width, $height) = getimagesize($url);
    $url_p = imagecreatetruecolor($answerToEverything, $answerToEverything);

    imagecopyresampled($url_p, $im, 0, 0, 0, 0, $answerToEverything, $answerToEverything, $width, $height);
    imagefilter($url_p, IMG_FILTER_PIXELATE, 2);

    $im = $url_p;

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
    if (($key = array_search('#FFFFFF', $colors)) !== false) {
        array_splice($colors, $key, 1);
    }

    for ($i = 0; $i < $answerToEverything * $answerToEverything; $i++) {
        if (isset($colors[$i])) {
            echo '<div style="height:50px; width:50px; background-color:' . $colors[$i] . '; display: inline-block;"></div>';

        }

    }
    echo "<br/>";
    echo "<br/>";

}




