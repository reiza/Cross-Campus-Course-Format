<?php
defined('MOODLE_INTERNAL') || die();

class CryptoForUWISharedCourse {
	private $encrypt_method = "AES-256-CBC";
	private $secret_key = '0m7nK6428p62N0f1cA7Ln99sIj0NHUG7';
	private $secret_iv = '';
	private $key;
	private $iv;
	
	public function __construct() {
		$this->key = hash('sha256', $this->secret_key);
		$this->iv = substr(hash('sha256', $this->secret_iv), 0, 16);
	}
	
	public function wrap($course){
		global $USER;
		
		$z = new StdClass();
		$z->a = $USER->username;
		$z->b = $course->m5mappingcampusid;
		$z->c = $course->m5mappingcourseid;
		
		$z = json_encode($z);
		//echo $z."<br>";
		$z = openssl_encrypt($z, $this->encrypt_method, $this->key, 0, $this->iv);
		//echo $z."<br>";
		$z = base64_encode($z);
		//echo $z."<br>";
		return $z;
	}
	
	
	public function unwrap($z){
		$z = base64_decode($z);
		$z = openssl_decrypt($z, $this->encrypt_method, $this->key, 0, $this->iv);
		$z = json_decode($z);
		return $z;
	}
	
	
}



	
?>