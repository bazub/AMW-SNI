<?php
session_start();
$client_id='973611819402.apps.googleusercontent.com';
$client_secret='*****';
$redirect_uri='http://announcemewhen.com/gplogin2.php';
$grant_type='authorization_code';

if(isset($_GET['code'])){
	$redir=$_GET['state'];
	$code=$_GET['code'];
	
	$url = 'https://accounts.google.com/o/oauth2/token';
	$data = array('code' => $code, 'client_id' => $client_id, 'client_secret' => $client_secret, 'redirect_uri' => $redirect_uri, 'grant_type' => $grant_type);
	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data),
		),
	);
	$context  = stream_context_create($options);
	$response = file_get_contents($url, false, $context);
	$var=json_decode($response);
	$access_token=$var->{'access_token'};
	$refresh_token=$var->{'refresh_token'};
	$signed_request=$var->{'id_token'};
	list($header, $payload, $encoded_sig) = explode('.', $signed_request, 3);
	$data=base64_decode($payload);
	$var=json_decode($data);
	$email=$var->{'email'};
	$id=$var->{'sub'};
	
	//include user in DB
	mysql_connect('annosocusers.db.10918050.hostedresource.com','annosocusers','*****');
	mysql_select_db('annosocusers');
	$sql="SELECT * FROM users WHERE email='".$email."' OR fbmail='".$email."' OR twmail='".$email."' or gpmail='".$email."'";
	$res=mysql_query($sql);
	if(isset($_SESSION['fbuid'])){
		#echo 'fb';
		$sql="UPDATE users SET gpuid='".$id."', gptoken='".$access_token."', gprefresh='".$refresh_token."', gpmail='".$email."' WHERE fbuid='".$_SESSION['fbuid']."'";
	}
	else if(isset($_SESSION['email'])){
		#echo 'email';
		$sql="UPDATE users SET gpuid='".$id."', gptoken='".$access_token."', gprefresh='".$refresh_token."', gpmail='".$email."' WHERE email='".$email."'";
	}
	else if(isset($_SESSION['twuid'])){
		#echo 'tw';
		$sql="UPDATE users SET gpuid='".$id."', gptoken='".$access_token."', gprefresh='".$refresh_token."', gpmail='".$email."' WHERE twuid='".$_SESSION['twuid']."'";
	}
	else if(mysql_num_rows($res)>0){ 
		#echo 'row';
		$row=mysql_fetch_array($res);
		if($row['gprefresh'])
			;
		else
			$sql="UPDATE users SET gpuid='".$id."', gptoken='".$access_token."', gprefresh='".$refresh_token."', gpmail='".$email."' WHERE email='".$email."' OR fbmail='".$email."' OR twmail='".$email."' OR gpmail='".$email."'";
	}
	else{
		$sql="INSERT INTO users (gpuid,gptoken,gprefresh,gpmail) VALUES ('".$id."','".$access_token."','".$refresh_token."','".$email."')";
	}
	mysql_query($sql) or die(mysql_error());
	$_SESSION['gpuid']=$id;
	
	$sql="SELECT * FROM users WHERE gpuid='".$_SESSION['gpuid']."'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if($row['fbuid']!='')
		$_SESSION['fbuid']=$row['fbuid'];
	if($row['twuid']!='')
		$_SESSION['twuid']=$row['twuid'];
	if($row['email']!='')
		$_SESSION['email']=$row['email'];
	echo '<meta http-equiv="Refresh" content="2; url=http://announcemewhen.com/login.php">';
}
else if(isset($_GET['error'])){
	echo '<meta http-equiv="Refresh" content="1; url=http://announcemewhen.com/loginerror">';
}

/*
bazu765@gmail.com

{ "access_token" : "ya29.AHES6ZTlwFO9dJjyxyxemj42LuFeMcGfpR0X-OjoxVEviTkW6EBGxw", "token_type" : "Bearer", "expires_in" : 3600, "id_token" : "eyJhbGciOiJSUzI1NiIsImtpZCI6IjU4MDk4NTc3NDM1N2U0ZWVhYjRlYzliOWI5MTNjNjBjNzZmYmFhNzYifQ.eyJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwidG9rZW5faGFzaCI6ImpjUjl5SDJPUEtaZlZBUVo0VzI4RFEiLCJhdF9oYXNoIjoiamNSOXlIMk9QS1pmVkFRWjRXMjhEUSIsImlkIjoiMTEwNjk0NjQ5MzgzNzQzNDQyNzU3Iiwic3ViIjoiMTEwNjk0NjQ5MzgzNzQzNDQyNzU3IiwidmVyaWZpZWRfZW1haWwiOiJ0cnVlIiwiZW1haWxfdmVyaWZpZWQiOiJ0cnVlIiwiY2lkIjoiOTczNjExODE5NDAyLmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwiYXpwIjoiOTczNjExODE5NDAyLmFwcHMuZ29vZ2xldXNlcmNvbnRlbnQuY29tIiwiZW1haWwiOiJiYXp1NzY1QGdtYWlsLmNvbSIsImF1ZCI6Ijk3MzYxMTgxOTQwMi5hcHBzLmdvb2dsZXVzZXJjb250ZW50LmNvbSIsImlhdCI6MTM3MDc4MTU5MCwiZXhwIjoxMzcwNzg1NDkwfQ.WUgCk2qaZfCuup9WPbJ3K7gxRKeDqJYRrHro6hOQh3VA-dPpu5DPN8uqLQvIYNFY05HbaSeT4uOs7fmZkYp-SYgTNhmFPv6M_qT1e29Es0b33iLD63WDgILuRUe3Io0c56eVdccEZovtoc2h_UWGTGcGUcyNVrWWqbtAtzham2M", "refresh_token" : "1/PE9ikz3peXv8kHWW-xmGM6bNOyFM3uFjacm1oVTqDGc" }
*/
?>