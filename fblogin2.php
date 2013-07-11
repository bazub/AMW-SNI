<?php
session_start();
$app_id='551362694914845';
$app_secret='******';
$app_token='*******';
$redirect_uri='http://announcemewhen.com/fblogin2.php';
if(isset($_GET['code'])){
	$code=$_GET['code'];
	$response=file_get_contents("https://graph.facebook.com/oauth/access_token?client_id=".$app_id."&redirect_uri=".$redirect_uri."&client_secret=".$app_secret."&code=".$code."");
	$r=explode('&',$response);
	$tmp=explode('=',$r[0]);
	$access_token=$tmp[1];
	$tmp=explode('=',$r[1]);
	$expires=$tmp[1];
	mysql_connect('annosocusers.db.10918050.hostedresource.com','annosocusers','******');
	mysql_select_db('annosocusers');
	$response=file_get_contents("https://graph.facebook.com/debug_token?input_token=".$access_token."&access_token=".$app_token."");
	$var=json_decode($response);
	if($var->{'data'}->{'app_id'}==$app_id){
		$response=file_get_contents("https://graph.facebook.com/me?access_token=".$access_token."");
		$var=json_decode($response);
		$email=$var->{'email'};
		$id=$var->{'id'};
		$_SESSION['fbuid']=$id;
		$sql="SELECT * FROM users WHERE email='".$email."' OR gpmail='".$email."' OR twmail='".$email."' OR fbmail='".$email."'";
		$res=mysql_query($sql) or die(mysql_error());
		if(mysql_num_rows($res)>0){
			$sql="UPDATE users SET fbuid='".$id."', fbtoken='".$access_token."', fbexpire='".$expires."', fbmail='".$email."' WHERE email='".$email."' OR gpmail='".$email."' OR twmail='".$email."' OR fbmail='".$email."'";
		}
		else if(isset($_SESSION['email'])){
			$sql="UPDATE users SET fbuid='".$id."', fbtoken='".$access_token."', fbexpire='".$expires."', fbmail='".$email."' WHERE email='".$email."'";
		}
		else if(isset($_SESSION['gpuid'])){
			$sql="UPDATE users SET fbuid='".$id."', fbtoken='".$access_token."', fbexpire='".$expires."', fbmail='".$email."' WHERE gpuid='".$_SESSION['gpuid']."'";
		}
		else if(isset($_SESSION['twuid'])){
			$sql="UPDATE users SET fbuid='".$id."', fbtoken='".$access_token."', fbexpire='".$expires."', fbmail='".$email."' WHERE twuid='".$_SESSION['twuid']."'";
		}
		else{
			$sql="INSERT INTO users (fbmail,fbuid,fbtoken,fbexpire) VALUES ('".$email."','".$id."','".$access_token."','".$expires."')";
		}
		mysql_query($sql);
		
		$sql="SELECT * FROM users WHERE fbuid='".$_SESSION['fbuid']."'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result);
		if($row['twuid']!='')
			$_SESSION['twuid']=$row['twuid'];
		if($row['gpuid']!='')
			$_SESSION['gpuid']=$row['gpuid'];
		if($row['email']!='')
			$_SESSION['email']=$row['email'];
		echo '<meta http-equiv="Refresh" content="2; url=http://announcemewhen.com/login.php">';
	}
	else echo 'error';
	
}
else if(isset($_GET['error']) && isset($_GET['error_reason']) && $_GET['error_reason']=='user_denied')
	echo '<meta http-equiv="Refresh" content="1; url=http://announcemewhen.com/loginerror">';




?>