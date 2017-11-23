<?php
require "../src/Aurphm.php";
use insomnius\Aurphm;

$hash_value     = $_POST['hash'];
$password       = $_POST['password'];
$credential     = $_POST['credential'];

$aurphm     = new Aurphm();

if($aurphm->hashCheck($credential, $password, $hash_value))
{
    $output['text']     = "Authentication success.";
    $output['type']     = "success";
    $output['title']    = "";
    
    echo json_encode($output);
}
else
{
    $output['text']     = "Authentication failed.";
    $output['type']     = "success";
    $output['title']    = "";
    
    echo json_encode($output);
}