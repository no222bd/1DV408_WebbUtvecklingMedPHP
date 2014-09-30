<?php

namespace model;

// Encrypts/Decrypts a string of characters
class TextScramblerModel {
	
	// The encryption/decryption key
	private static $key = 'DettaVarInteLätt';

	// Encrypt and return the supplied string 
	public static function encrypt($text) {
		return mcrypt_encrypt(MCRYPT_BLOWFISH, self::$key, $text, MCRYPT_MODE_ECB);
	}

	// Decrypt and return the supplied string 
	public static function decrypt($text) {
		return mcrypt_decrypt(MCRYPT_BLOWFISH, self::$key, $text, MCRYPT_MODE_ECB);
	}
}