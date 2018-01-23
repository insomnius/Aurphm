<?php
require "../src/Aurphm/Aurphm.php";
use Aurphm\Aurphm;

if(!isset($_POST['credential']))
{
    return false;
}

try{ 
    $credential = $_POST['credential'];
    $key        = $_POST['key'];
    $length     = $_POST['length'];
    $iteration  = $_POST['iteration'];
    $prefix     = $_POST['prefix'];
    $saltalgo        = $_POST['saltalgo'];
    $useruniquealgo  = $_POST['useruniquealgo'];
    $signaturealgo   = $_POST['signaturealgo'];
    
    $hash       = Aurphm::init()->setIteration($iteration)
                ->setPrefix($prefix)
                ->setSignatureLength($length)
                ->setSaltAlgo($saltalgo)
                ->setUserUniqueAlgo($useruniquealgo)
                ->setSignatureAlgo($signaturealgo)
                ->hash($credential, $key);
    
    echo $hash;
}
catch(Exception $e) 
{
    echo $e;
}