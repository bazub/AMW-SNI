<?php
session_start();
$oauthToken=$_GET['oauth_token'];
if(isset($_SESSION['tw_oauth_token']) AND $_SESSION['tw_oauth_token']==$oauthToken){
	$consumerKey='WoCUD90H0clenUYrB7ZUOg';
	$consumerSecret='******';
	$oauthVersion = "1.0";
	$oauthSignatureMethod = "HMAC-SHA1"; 
	$accessTokenUrl = "http://api.twitter.com/oauth/access_token"; 
	$nonce = md5(mt_rand()); 
	$oauthTimestamp = time();
	$oauthVerifier = $_GET["oauth_verifier"]; 

	$sigBase = "GET&" . rawurlencode($accessTokenUrl) . "&"
		. rawurlencode("oauth_consumer_key=" . rawurlencode($consumerKey)
		. "&oauth_nonce=" . rawurlencode($nonce)
		. "&oauth_signature_method=" . rawurlencode($oauthSignatureMethod)
		. "&oauth_timestamp=" . rawurlencode($oauthTimestamp)
		. "&oauth_token=" . rawurlencode($_SESSION["tw_oauth_token"])
		. "&oauth_verifier=" . rawurlencode($oauthVerifier)
		. "&oauth_version=" . rawurlencode($oauthVersion)); 
		
	$sigKey = $consumerSecret . "&"; 
	$oauthSig = base64_encode(hash_hmac("sha1", $sigBase, $sigKey, true));

	$requestUrl = $accessTokenUrl . "?"
		. "oauth_consumer_key=" . rawurlencode($consumerKey)
		. "&oauth_nonce=" . rawurlencode($nonce)
		. "&oauth_signature_method=" . rawurlencode($oauthSignatureMethod)
		. "&oauth_timestamp=" . rawurlencode($oauthTimestamp)
		. "&oauth_token=" . rawurlencode($_SESSION["tw_oauth_token"])
		. "&oauth_verifier=" . rawurlencode($oauthVerifier)
		. "&oauth_version=". rawurlencode($oauthVersion)
		. "&oauth_signature=" . rawurlencode($oauthSig); 

	$response = file_get_contents($requestUrl);
	#echo $response;
	parse_str($response, $values);
	$oauth_token=$values['oauth_token'];
	$oauth_token_secret=$values['oauth_token_secret'];
	$id=$values['user_id'];
	$_SESSION['twuid']=$id;
	unset($_SESSION['tw_oauth_token']);
	unset($_SESSION['tw_oauth_token_secret']);
	mysql_connect('annosocusers.db.10918050.hostedresource.com','annosocusers','*****');
	mysql_select_db('annosocusers');
	
	$sql="SELECT * FROM users WHERE email='".$email."' OR fbmail='".$email."' OR twmail='".$email."' or gpmail='".$email."'";
	$res=mysql_query($sql);
	if (mysql_num_rows($res)>0){
		$sql="UPDATE users SET twuid='".$id."', twtoken='".$oauth_token."', twsecret='".$oauth_token_secret."' WHERE email='".$email."' OR fbmail='".$email."' OR twmail='".$email."' OR gpmail='".$email."'";
	}
	else if(isset($_SESSION['email'])){
		$sql="UPDATE users SET twuid='".$id."', twtoken='".$oauth_token."', twsecret='".$oauth_token_secret."' WHERE email='".$email."'";
	}
	else if(isset($_SESSION['fbuid'])){
		$sql="UPDATE users SET twuid='".$id."', twtoken='".$oauth_token."', twsecret='".$oauth_token_secret."' WHERE fbuid='".$_SESSION['fbuid']."'";
	}
	else if(isset($_SESSION['gpuid'])){
		$sql="UPDATE users SET twuid='".$id."', twtoken='".$oauth_token."', twsecret='".$oauth_token_secret."' WHERE gpuid='".$_SESSION['gpuid']."'";
	}
	else{
		$_SESSION['oauth_token']=$oauth_token;
		$_SESSION['oauth_token_secret']=$oauth_token_secret;
		echo '<meta http-equiv="Refresh" content="1; url=http://announcemewhen.com/twittermail.php">';
	}
	mysql_query($sql);
	
	$sql="SELECT * FROM users WHERE twuid='".$_SESSION['twuid']."'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if($row['fbuid']!='')
		$_SESSION['fbuid']=$row['fbuid'];
	if($row['gpuid']!='')
		$_SESSION['gpuid']=$row['gpuid'];
	if($row['email']!='')
		$_SESSION['email']=$row['email'];
	echo '<meta http-equiv="Refresh" content="2; url=http://announcemewhen.com/login.php">';
}
else{
	header('Location: http://www.google.com/')

}





?>