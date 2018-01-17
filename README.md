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

	require "../src/Aurphm.php";
	use insomnius\Aurphm;

	$credential = "credential";
	$key   		= "key";

	$hash       = Aurphm::hash($credential, $key);
	
	echo $hash;

The hash result will be random every generation and the one of the result is:

AURPHM_e61ab321cb332f094cecb1c51837e119c004b9a9184ab2fa5d7949d0e01cd861.bdded20f6553afab6b4b6ba9f8f35220742bc5bbee83cdf25314043a02fa70e13f29d41be690e44927a84778c3f791622dd6664592085c12b6a351c0154c0b70.UC_0419c4e12dd4196a5150354c2f17093d46de252c2d9abf976c3ca5d81e8af664