## About Aurphm
Aurelia pseudo hashing method (Aurphm) is my experimental function to hash password with HMAC (Hash-based message authentication code), PBKDF2 (Password-Based Key Derivation Function 2) and Pseudo Random Bytes. The main reason to create this library is to make good hash for security reason and the hash must be:

 - Has a random salt every hash generation
 - Has a user unique hash so it will generate differently if the key and credential is different
 - Has a unique signature for authentication
 - Has a different hash value every hash generation but still can be authenticated
 - We can set their prefered algorithm for each method (salt, user unique, signature)
 - Simple to authenticate

This library is inspired by a post in **crackstation** about how to make secure hash [here](https://crackstation.net/hashing-security.htm).

## How to use
Here is a simple step to generate a hash:
```php
	require "../src/Aurphm.php";
	use insomnius\Aurphm;

	$credential = "credential";
	$key   		= "key";

	$hash       = Aurphm::hash($credential, $key);
	
	echo $hash;
```
The hash result will be random every generation and the one of the result is:

![hash-result-example](https://raw.githubusercontent.com/insomnius/Aurphm/master/hash-value.png "Hash result example")

And there is an advanced configuration too, you can change how much iteration on PBKDF, the prefix, signature length, salt algorithm, algorithm for creating user unique hash and algorithm for signature.

Here is the example code:

```php
    $credential = 'credential';
	$key        = 'key';
    $length     = 128;
    $iteration  = 64;
    $prefix     = 'GITHUB';
    
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
```