<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Twitter
{

	public function send($msg) {
		require_once 'twitter/twitter.class.php';
		
		$consumerKey = $_SERVER['CONSUMERKEY'];
		$consumerSecret = $_SERVER['CONSUMERSECRET'];
		$accessToken = $_SERVER['ACCESSTOKEN'];
		$accessTokenSecret = $_SERVER['ACCESSTOKENSECRET'];
		
		$twitter = new Twitter_class($consumerKey, $consumerSecret, $accessToken, $accessTokenSecret);
		$status = $twitter->send($msg);
		
		echo $status ? 'OK' : 'ERROR';
	}
}