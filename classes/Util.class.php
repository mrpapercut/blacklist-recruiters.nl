<?php

class Util {

	public function truncateText($text) {
		if (strlen($text) > 350) {
			$text = substr($text, 0, 350);
			preg_match('/(.*)\s/', $text, $text);
			return $text[1].'...';
		} else {
			return $text;
		}
	}

	public function getMailToken($insertid) {
		return hash('sha256', time().$insertid);
	}

    public function encrypt($string) {
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', HASH_KEY);
        $iv = openssl_random_pseudo_bytes(16);

        return base64_encode($iv.openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    }

    public function decrypt($string) {
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', HASH_KEY);

        $decoded = base64_decode($string);
        $iv = substr($decoded, 0, 16);
        $cipher = substr($decoded, 16);

        return openssl_decrypt($cipher, $encrypt_method, $key, 0, $iv);
    }
}
