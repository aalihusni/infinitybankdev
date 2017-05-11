<?php
/*
Name: 			Twitter Feed
Written by: 	Okler Themes - (http://www.okler.net)
Version: 		2.1.0
*/

session_start();
require_once("twitteroauth/twitteroauth.php");

// Replace the keys below - Go to https://dev.twitter.com/apps to create the Application
$consumerkey = "1111111111111111111111";
$consumersecret = "11111111111111111111111111111111111111111";
$accesstoken = "1111111111-111111111111111111111111111111111111111";
$accesssecret = "111111111111111111111111111111111111111111111";


$twitteruser = $_GET['twitteruser'];
$notweets = $_GET['notweets'];

function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
	$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
	return $connection;
}

$connection = getConnectionWithAccessToken($consumerkey, $consumersecret, $accesstoken, $accesssecret);
$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitteruser."&count=".$notweets);

echo json_encode($tweets);
?>