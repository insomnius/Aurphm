
## About Aurphm
Aurelia pseudo hashing method (Aurphm) is my experimental function to hash password with HMAC (Hash-based message authentication code), PBKDF2 (Password-Based Key Derivation Function 2) and Pseudo Random Bytes. The main reason to create this library is to make good hash for security reason and the hash must be:

 - Has a random salt every hash generation
 - Has a user unique hash so it will generate differently if the key and credential is different using HMAC
 - Has a unique signature for authentication using PBKDF2
 - Has a different hash value every hash generation but still can be authenticated
 - We can set their prefered algorithm for each method (salt, user unique, signature)
 - Simple to authenticate

This library is inspired by a post in **crackstation** about how to make secure hash [here](https://crackstation.net/hashing-security.htm).

## How to use
Here is a simple step to generate a hash:
```php
	require "../src/Aurphm/Aurphm.php";
	use Aurphm\Aurphm;

	$credential = "credential";
	$key = "key";

	$hash = Aurphm::hash($credential, $key);
	
	echo $hash;
```
The hash result will be random every generation and the one of the result is:

![hash-result-example](https://raw.githubusercontent.com/insomnius/Aurphm/master/hash-value.png "Hash result example")

And there is an advanced configuration too, you can change how much iteration on PBKDF, the prefix, signature length, salt algorithm, algorithm for creating user unique hash and algorithm for signature.

Here is the example code:

```php
    $credential = 'credential';
	$key = 'key';
    $length = 128;
    $iteration = 64;
    $prefix = 'GITHUB';
    
    $saltalgo = 'SHA1';
    $useruniquealgo = 'SHA256';
    $signaturealgo = 'MD5';
    
    $hash = Aurphm::init()->setIteration($iteration) // You have to use ini to called this function statically, Set the iteration of pbkdf
                ->setPrefix($prefix) // Set the prefix of the hash
                ->setSignatureLength($length) // Set signature length
                ->setSaltAlgo($saltalgo) // Set salt hash algorithm
                ->setUserUniqueAlgo($useruniquealgo) // Set user unique hash algorithm (hmac algorithm)
                ->setSignatureAlgo($signaturealgo) // Set signature hash algorithm (pbkdf algorithm)
                ->hash($credential, $key);
    
    echo $hash;
```
And here is the result look like:

![hash-result-advanced-example](https://raw.githubusercontent.com/insomnius/Aurphm/master/hash-value-advanced.png 'Hash result advanced example')

And lastly, how about authenticate? we can do that in simple way too like this:
```php
$hash_value = 'AURPHM_e61ab31BBLABLABLABLABLABLABLABLA';
$key = 'key';
$credential = 'credential';

if(Aurphm::authenticate($credential, $key, $hash_value))
{
    echo "Authentication success!";
}
else
{
    echo "Authentication failed.";
}
```
## Download
You can download this package via github release, and if you using composer just type this and the magic is doing the work.

	composer require insomnius/aurphm

## Demo
You can also view the demo i made in tests folder using php development server, just type this in your command prompt if you're using windows (make sure you are in the root directory of this project):
    
    php -S localhost:7800 -t ./tests/

And then open your browser with address http:\\localhost:7800.

That's it, have fun to use it! :)