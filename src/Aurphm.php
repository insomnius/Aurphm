<?php
//-- Aurelia Pseudo Hashing Method
//-- Created by Arib
//-- Thanks to Genoffe Studio for supporting me create this class
//-- http://genoffe.com

namespace Insomnius;

use Exception;

class Aurphm
{

    protected $iteration        = 16;
    protected $pbkdf2_length    = 64;
    protected $prefix           = "AURPHM";
    
    protected $salt_algo        = "SHA256";
    protected $userunique_algo  = "SHA512";
    protected $signature_algo   = "SHA512";

    public function __construct()
    {

    }

    protected function getSalt($AURPHM)
    {
        $validationArray    = explode(".", $AURPHM);

        $tobeSalt           = $validationArray[0];

        $salt               = explode("_", $tobeSalt);

        $returnSalt         = $salt[1];

        return $returnSalt;
    }

    protected function getSignature($AURPHM)
    {
        $validationArray    = explode(".", $AURPHM);
        $signature          = $validationArray[2];

        return $signature;
    }

    public function setIteration($iteration)
    {
        if(!is_numeric($iteration))
        {
            throw new Exception("Iteration value must be integer.");
        }

        $this->iteration    = $iteration;

        return $this;
    }

    public function setPrefix($prefix)
    {
        $this->prefix       = $prefix;

        return $this;
    }

    static public function list()
    {
        return hash_algos();
    }

    public function setSignatureLength($length)
    {
        if($length < 16)
        {
            throw new Exception("Password length can't be less than 16 character.");
        }

        $this->pbkdf2_length    = $length;

        return $this;
    }

    public function setSaltAlgo($algo)
    {
        if(array_search(strtolower($algo), self::list()))
        {
            throw new Exception("This hash algorithm '$algo' not avalaible in you php version.");
        }

        $this->salt_algo    = $algo;
        return $this;
    }

    public function setUserUniqueAlgo($algo)
    {
        if(array_search(strtolower($algo), self::list()))
        {
            throw new Exception("This hash algorithm '$algo' not avalaible in you php version.");
        }

        $this->userunique_algo  = $algo;
        return $this;
    }

    public function setSignatureAlgo($algo)
    {
        if(array_search(strtolower($algo), self::list()))
        {
            throw new Exception("This hash algorithm '$algo' not avalaible in you php version.");
        }

        $this->signature_algo   = $algo;
        return $this;
    }

    public function generateHashing($credential, $password)
    {
        $randomChar     = bin2hex(random_bytes(64));
        $randomCharSSL  = bin2hex(openssl_random_pseudo_bytes(64));
        
        $hmacHash       = hash_hmac($this->salt_algo, $password.$randomChar.$randomCharSSL, $randomChar.$randomCharSSL);
        
        $prefix         = $this->prefix . "_";
        
        $userUnique     = hash_hmac($this->userunique_algo, $credential.$password, $hmacHash);
        
        $beforeMerge    = "$prefix$hmacHash.$userUnique.UC_";

        $pbkdf2         = hash_pbkdf2($this->signature_algo, $userUnique, $hmacHash, $this->iteration, $this->pbkdf2_length);
        
        $hashed         = $beforeMerge.$pbkdf2;
        
        return $hashed;
    }

    public function hashCheck($credential, $password, $passwordDB)
    {
        $salt           = $this->getSalt($passwordDB);
        $signature      = $this->getSignature($passwordDB);

        $userUnique     = hash_hmac("SHA512", $credential.$password, $salt);

        $pbkdf2         = "UC_".hash_pbkdf2("SHA512", $userUnique, $salt, $this->iteration, $this->pbkdf2_length);

        if(hash_equals($pbkdf2, $signature))
        {
            return true;
        }else{
            return false;
        }
    }

}