<?php
require "../src/Aurphm/Aurphm.php";
use Aurphm;

$algo       = Aurphm::list();
$content    = "";

foreach($algo as $key => $value)
{
    $content    .= "<li>$value</li>";
}

echo $content;