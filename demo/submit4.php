<?php
require "../vendor/autoload.php";
use Aurphm\Aurphm;

$hash_value     = $_POST['hash'];
$key            = $_POST['key'];
$credential     = $_POST['credential'];

if(Aurphm::authenticate($credential, $key, $hash_value))
{
    $output['text']     = "Authentication success.";
    $output['type']     = "success";
    $output['title']    = "";
    
    echo json_encode($output);
}
else
{
    $output['text']     = "Authentication failed.";
    $output['type']     = "error";
    $output['title']    = "";
    
    echo json_encode($output);
}