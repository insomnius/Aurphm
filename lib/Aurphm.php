<?php
//-- Aurelia Pseudo Hashing Method
//-- Created by Arib

class Aurphm
{

    protected $iteration    = 16;
    protected $length       = 512;
    protected $prefix       = "AURPHFAS";

    protected function getSalt($AURPHFAS){
        $validationArray    = explode(".", $AURPHFAS);

        $tobeSalt           = $validationArray[0];

        $salt               = explode("_", $tobeSalt);

        $returnSalt         = $salt[1];

        return $returnSalt;
    }

    protected function getSignature($AURPHFAS){ //-- Get signature from user password
        $validationArray    = explode(".", $AURPHFAS);
        $signature          = $validationArray[2];

        return $signature;
    }

    public function setIteration($iteration)
    {
        if(!is_numeric($iteration))
        {
            return "Iteration value must be integer.";
        }

        $this->iteration    = $iteration;

        return $this;
    }

    public function setPrefix($prefix)
    {
        $this->prefix       = $prefix;

        return $this;
    }

    public function setLength($length)
    {
        if($length < 256)
        {
            return "Password length can't be less than 256 character.";
        }

        $this->length       = $length;

        return $this;
    }

    public function generateHashing($credential, $password)
    {
        $randomChar     = bin2hex(random_bytes(64));
        $randomCharSSL  = bin2hex(openssl_random_pseudo_bytes(64));
        
        $hmacHash       = hash_hmac("SHA256", $password.$randomChar.$randomCharSSL, $randomChar.$randomCharSSL);
        
        $prefix         = $this->prefix . "_";
        
        $userUnique     = hash_hmac("SHA512", $credential.$password, $hmacHash);
        
        $beforeMerge    = "$prefix$hmacHash.$userUnique.UC_";

        $pbkdf2         = hash_pbkdf2("SHA512", $userUnique, $hmacHash, $this->iteration, $this->length - strlen($beforeMerge));
        
        $hashed         = $beforeMerge.$pbkdf2;
        
        return $hashed;
    }

    public function hashCheck($credential, $password, $passwordDB)
    {
        $salt           = $this->getSalt($passwordDB);
        $signature      = $this->getSignature($passwordDB);

        $userUnique     = hash_hmac("SHA512", $credential.$password, $salt);

        $pbkdf2         = "UC_".hash_pbkdf2("SHA512", $userUnique, $salt, $this->iteration, 306);

        if($pbkdf2 == $signature){
            return true;
        }else{
            return false;
        }
    }

}