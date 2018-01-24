<?php
require "../vendor/autoload.php";
use Aurphm\Aurphm;

if(!isset($_POST['credential']))
{
    return false;
}

$credential = $_POST['credential'];
$key        = $_POST['key'];

$hash       = Aurphm::hash($credential, $key);

echo $hash;