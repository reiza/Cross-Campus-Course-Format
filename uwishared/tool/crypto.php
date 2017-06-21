<?php
/**
* @package    format_uwishared
* @copyright OC Dev Team
*/
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

	public function wrapCourse($course){
		global $USER, $CFG;

		$z = new StdClass();
		$z->t = time();
		$z->a = $USER->id;
		$z->b = get_config('format_uwishared')->smimappingcampusid;
		$z->c = $course->smicourseid;
		$z->d = $CFG->wwwroot;

		return $this->wrap($z);
	}


	public function wrap($z){
		$z = json_encode($z);
		$z = openssl_encrypt($z, $this->encrypt_method, $this->key, 0, $this->iv);
		$z = base64_encode($z);
		return $z;
	}


	public function unwrap($z){
		$z = base64_decode($z);
		$z = openssl_decrypt($z, $this->encrypt_method, $this->key, 0, $this->iv);
		$z = json_decode($z);
		return $z;
	}


}
