<?php
session_start();
$requestTokenUrl = "http://api.twitter.com/oauth/request_token"; 
$authorizeUrl = "http://api.twitter.com/oauth/authorize";
$oauthTimestamp = time();
$nonce = md5(mt_rand()); 
$oauthSignatureMethod = "HMAC-SHA1"; 
$oauthVersion = "1.0";
$consumerKey='WoCUD90H0clenUYrB7ZUOg';
$consumerSecret='*******';

$sigBase = "GET&" . rawurlencode($requestTokenUrl) . "&"
    . rawurlencode("oauth_consumer_key=" . rawurlencode($consumerKey)
    . "&oauth_nonce=" . rawurlencode($nonce)
    . "&oauth_signature_method=" . rawurlencode($oauthSignatureMethod)
    . "&oauth_timestamp=" . $oauthTimestamp
    . "&oauth_version=" . $oauthVersion); 
    

$sigKey = $consumerSecret . "&"; 
$oauthSig = base64_encode(hash_hmac("sha1", $sigBase, $sigKey, true));	


$requestUrl = $requestTokenUrl . "?"
    . "oauth_consumer_key=" . rawurlencode($consumerKey)
    . "&oauth_nonce=" . rawurlencode($nonce)
    . "&oauth_signature_method=" . rawurlencode($oauthSignatureMethod)
    . "&oauth_timestamp=" . rawurlencode($oauthTimestamp)
    . "&oauth_version=" . rawurlencode($oauthVersion)
    . "&oauth_signature=" . rawurlencode($oauthSig); 

$response = file_get_contents($requestUrl);
list($oauth_token,$oauth_token_secret,$callback_confirmed)=explode('&', $response, 3);
list($blabla,$oauth_token)=explode('=', $oauth_token,2);
list($blabla,$oauth_token_secret)=explode('=', $oauth_token_secret,2);
$_SESSION['tw_oauth_token']=$oauth_token;
$_SESSION['tw_oauth_token_secret']=$oauth_token_secret;

echo '<meta http-equiv="Refresh" content="0; url=https://api.twitter.com/oauth/authenticate?oauth_token='.$oauth_token.'">';
?>