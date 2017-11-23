<?php
require "../src/Aurphm.php";
use insomnius\Aurphm;

if(!isset($_POST['credential']))
{
    return false;
}

try{ 
    $credential = $_POST['credential'];
    $password   = $_POST['password'];
    $length     = $_POST['length'];
    $iteration  = $_POST['iteration'];
    $prefix     = $_POST['prefix'];
    $saltalgo        = $_POST['saltalgo'];
    $useruniquealgo  = $_POST['useruniquealgo'];
    $signaturealgo   = $_POST['signaturealgo'];

    $aurphm     = new Aurphm();
    
    $hash       = $aurphm->setIteration($iteration)
                    ->setPrefix($prefix)
                    ->setSignatureLength($length)
                    ->setSaltAlgo($saltalgo)
                    ->setUserUniqueAlgo($useruniquealgo)
                    ->setSignatureAlgo($signaturealgo)
                    ->generateHashing($credential, $password);
    
    echo $hash;
}
catch(Exception $e) 
{
    echo $e;
}