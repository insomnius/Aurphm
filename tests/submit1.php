<?php
require "../src/Aurphm.php";
use insomnius\Aurphm;

if(!isset($_POST['credential']))
{
    return false;
}

$credential = $_POST['credential'];
$password   = $_POST['password'];

$aurphm     = new Aurphm();
$hash       = $aurphm->generateHashing($credential, $password);

echo $hash;