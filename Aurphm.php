<?php
//-- Aurelia Pseudo Hashing Method
//-- Created by Arib

class Aurphm
{

    public static function getSalt($AURPHFAS){
        $validationArray    = explode(".", $AURPHFAS);

        $tobeSalt           = $validationArray[0];

        $salt               = explode("_", $tobeSalt);

        $returnSalt         = $salt[1];

        return $returnSalt;
    }

    public static function getSignature($AURPHFAS){ //-- Get signature from user password
        $validationArray    = explode(".", $AURPHFAS);
        $signature          = $validationArray[2];

        return $signature;
    }

    public static function generateHashing($credential, $password)
    {
        $randomChar     = bin2hex(random_bytes(64));
        $randomCharSSL  = bin2hex(openssl_random_pseudo_bytes(64));
        
        $hmacHash       = hash_hmac("SHA256", $password.$randomChar.$randomCharSSL, $randomChar.$randomCharSSL);
        
        $prefix         = "AURPHFAS_";
        
        $userUnique     = hash_hmac("SHA512", $credential.$password, $hmacHash);
        
        $pbkdf2         = hash_pbkdf2("SHA512", $userUnique, $hmacHash, 16, 306);
        
        $hashed         = "$prefix$hmacHash.$userUnique.UC_$pbkdf2";
        
        return $hashed;
    }

    public static function hashCheck($credential, $password, $passwordDB)
    {
        $salt           = AURPHFAS::getSalt($passwordDB);
        $signature      = AURPHFAS::getSignature($passwordDB);

        $userUnique     = hash_hmac("SHA512", $credential.$password, $salt);

        $pbkdf2         = "UC_".hash_pbkdf2("SHA512", $userUnique, $salt, 16, 306);

        if($pbkdf2 == $signature){
            return true;
        }else{
            return false;
        }
    }

}