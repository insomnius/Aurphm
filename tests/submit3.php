<?php
require "../src/Aurphm.php";
use insomnius\Aurphm;

$algo       = Aurphm::list();
$content    = "";

foreach($algo as $key => $value)
{
    $content    .= "<li>$value</li>";
}

echo $content;