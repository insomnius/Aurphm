<?php
require "../src/Aurphm.php";
use insomnius\Aurphm;

if(!isset($_POST['credential']))
{
    return false;
}

$credential = $_POST['credential'];
$password   = $_POST['password'];

$hash       = Aurphm::hash($credential, $password);

echo $hash;