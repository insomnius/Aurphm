<?php
require "../src/Aurphm.php";
use insomnius\Aurphm;

if(!isset($_POST['credential']))
{
    return false;
}

$credential = $_POST['credential'];
$password   = $_POST['password'];
$length     = $_POST['length'];
$iteration  = $_POST['iteration'];
$prefix     = $_POST['prefix'];

$aurphm     = new Aurphm();

$hash       = $aurphm->setIteration($iteration)->setPrefix($prefix)->setLength($length)->generateHashing($credential, $password);

echo $hash;