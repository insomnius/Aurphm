<?php

//-- Aurelia Pseudo Hashing Method
//-- Created by Arib

namespace Insomnius;

use Exception;

class Aurphm
{
    protected $iteration            = 16;
    protected $signature_length     = 64;
    protected $prefix               = "AURPHM";
    
    protected $salt_algo            = "SHA256";
    protected $userunique_algo      = "SHA512";
    protected $signature_algo       = "SHA512";

    public static function init()
    {
        return new self;
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

    public function setSignatureLength($length)
    {
        if($length < 16)
        {
            throw new Exception("Signature length can't be less than 16 character.");
        }

        $this->signature_length     = $length;

        return $this;
    }

    public function setSaltAlgo($algo)
    {
        if(!array_search(strtolower($algo), self::list()))
        {
            throw new Exception("This hash algorithm '$algo' not avalaible in you php version.");
        }

        $this->salt_algo    = $algo;
        return $this;
    }

    public function setUserUniqueAlgo($algo)
    {
        if(!array_search(strtolower($algo), self::list()))
        {
            throw new Exception("This hash algorithm '$algo' not avalaible in you php version.");
        }

        $this->userunique_algo  = $algo;
        return $this;
    }

    public function setSignatureAlgo($algo)
    {
        if(!array_search(strtolower($algo), self::list()))
        {
            throw new Exception("This hash algorithm '$algo' not avalaible in you php version.");
        }

        $this->signature_algo   = $algo;
        return $this;
    }

    public static function list()
    {
        return hash_algos();
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

    protected function generateHashing($credential, $key)
    {
        $randomChar     = bin2hex(random_bytes(64));
        $randomCharSSL  = bin2hex(openssl_random_pseudo_bytes(64));
        
        $hmacHash       = hash_hmac($this->salt_algo, $key.$randomChar.$randomCharSSL, $randomChar.$randomCharSSL);
        
        $prefix         = $this->prefix . "_";
        
        $userUnique     = hash_hmac($this->userunique_algo, $credential.$key, $hmacHash);
        
        $beforeMerge    = "$prefix$hmacHash.$userUnique.UC_";

        $pbkdf2         = hash_pbkdf2($this->signature_algo, $userUnique, $hmacHash, $this->iteration, $this->signature_length);
        
        $hashed         = $beforeMerge.$pbkdf2;
        
        return $hashed;
    }

    public static function hash($credential, $key)
    {
        return (new self)->generateHashing($credential, $key);
    }

    protected function hashCheck($credential, $key, $hash)
    {
        $salt           = $this->getSalt($hash);
        $signature      = $this->getSignature($hash);

        $userUnique     = hash_hmac("SHA512", $credential.$key, $salt);

        $pbkdf2         = "UC_".hash_pbkdf2("SHA512", $userUnique, $salt, $this->iteration, $this->signature_length);

        if(hash_equals($pbkdf2, $signature))
        {
            return true;
        }else{
            return false;
        }
    }

    public static function authenticate($credential, $key, $hash)
    {
        return (new self)->hashCheck($credential, $key, $hash);
    }
}