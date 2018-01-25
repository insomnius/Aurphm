<?php

//-- Aurelia Pseudo Hashing Method
//-- Created by Arib

namespace Aurphm;

use Exception;

/**
 * A simple API extension for DateTime
 *
 * @property      int $iteration
 * @property      int $PBKDF_length
 * @property      string $prefix
 * @property      string $salt_algo
 * @property      string $HMAC_algo
 * @property      string $PBKDF_algo
 */

class Aurphm
{
    protected static $iteration     = 16;
    protected static $PBKDF_length  = 64;
    protected static $prefix        = "AURPHM";
    
    protected static $salt_algo     = "SHA256";
    protected static $HMAC_algo     = "SHA512";
    protected static $PBKDF_algo    = "SHA512";

    /**
     * Static initation
     * @return object
     */
    public static function init()
    {
        return new self;
    }

    /**
     * Set how much PBKDF iteration.
     * @param int $iteration
     * @return object
     */
    public function setIteration($iteration)
    {
        if(!is_numeric($iteration))
        {
            throw new Exception("Iteration value must be integer.");
        }

        self::$iteration    = $iteration;

        return $this;
    }

    /**
     * Set the prefix of hash string.
     * @param string $prefix
     * @return object
     */
    public function setPrefix($prefix)
    {
        self::$prefix       = $prefix;

        return $this;
    }

    /**
     * Set the length of PBKDF hash result.
     * @param int $length, can't be more than 16 characters
     * @return object
     */
    public function setSignatureLength($length)
    {
        if($length < 16)
        {
            throw new Exception("Signature length can't be less than 16 character.");
        }

        self::$PBKDF_length     = $length;

        return $this;
    }

    /**
     * Set an algorithm for hashing HMAC in salt.
     * @param string $algo
     * @return object
     */
    public function setSaltAlgo($algo)
    {
        if(!array_search(strtolower($algo), self::list()))
        {
            throw new Exception("This hash algorithm '$algo' not avalaible in you php version.");
        }

        self::$salt_algo    = $algo;
        return $this;
    }

    /**
     * Set an algorithm for user unique hash with HMAC.
     * @param string $algo
     * @return object
     */
    public function setUserUniqueAlgo($algo)
    {
        if(!array_search(strtolower($algo), self::list()))
        {
            throw new Exception("This hash algorithm '$algo' not avalaible in you php version.");
        }

        self::$HMAC_algo  = $algo;
        return $this;
    }

    /**
     * Set PBKDF algorithm for user signature.
     * @param string $algo
     * @return object
     */
    public function setSignatureAlgo($algo)
    {
        if(!array_search(strtolower($algo), self::list()))
        {
            throw new Exception("This hash algorithm '$algo' not avalaible in you php version.");
        }

        self::$PBKDF_algo   = $algo;
        return $this;
    }

    /**
     * Get hash algorithm list that you have.
     * @return array
     */
    public static function list()
    {
        return hash_algos();
    }

    /**
     * Get the salt from AURPHM hash result.
     * @param string $AURPHM
     * @return string
     */
    protected function getSalt($AURPHM)
    {
        $validationArray    = explode(".", $AURPHM);

        $tobeSalt           = $validationArray[0];

        $salt               = explode("_", $tobeSalt);

        $returnSalt         = $salt[1];

        return $returnSalt;
    }

    /**
     * Get signature from AURPHM hash result.
     * @param string $AURPHM
     * @return string
     */
    protected function getSignature($AURPHM)
    {
        $validationArray    = explode(".", $AURPHM);
        $signature          = $validationArray[2];

        return $signature;
    }

    /**
     * Hash function
     * @param string $credential
     * @param string $key
     * @return string
     */
    public static function hash($credential, $key)
    {
        $randomChar     = bin2hex(random_bytes(64));
        $randomCharSSL  = bin2hex(openssl_random_pseudo_bytes(64));
        
        $hmacHash       = hash_hmac(self::$salt_algo, $key.$randomChar.$randomCharSSL, $randomChar.$randomCharSSL);
        
        $prefix         = self::$prefix . "_";
        
        $userUnique     = hash_hmac(self::$HMAC_algo, $credential.$key, $hmacHash);
        
        $beforeMerge    = "$prefix$hmacHash.$userUnique.UC_";

        $pbkdf2         = hash_pbkdf2(self::$PBKDF_algo, $userUnique, $hmacHash, self::$iteration, self::$PBKDF_length);
        
        $hashed         = $beforeMerge.$pbkdf2;
        
        return $hashed;
    }

    /**
     * Authenticate the hash result of AURPHM
     * @param string $credential
     * @param string $key
     * @param string $hash
     * @return boolean
     */
    public static function authenticate($credential, $key, $hash)
    {
        $salt           = self::getSalt($hash);
        $signature      = self::getSignature($hash);

        $userUnique     = hash_hmac(self::$HMAC_algo, $credential.$key, $salt);

        $pbkdf2         = "UC_".hash_pbkdf2(self::$PBKDF_algo, $userUnique, $salt, self::$iteration, self::$PBKDF_length);

        if(hash_equals($pbkdf2, $signature))
        {
            return true;
        }else{
            return false;
        }
    }

}