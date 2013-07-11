<?php
session_start();

if(isset($_POST['twmail'])){
	mysql_connect('annosocusers.db.10918050.hostedresource.com','annosocusers','*****');
	mysql_select_db('annosocusers');
	$sql="SELECT * FROM users WHERE email='".$email."' OR fbmail='".$email."' OR twmail='".$email."' or gpmail='".$email."'";
	$res=mysql_query($sql);
	if(mysql_num_rows($res)>0){ 
		$sql="UPDATE users SET UPDATE users SET twuid='".$id."', twtoken='".$oauth_token."', twsecret='".$oauth_token_secret."' WHERE email='".$email."' OR fbmail='".$email."' OR twmail='".$email."' OR gpmail='".$email."'";
		mysql_query($sql);
	}
	else{
		$sql="INSERT INTO users (twmail,twuid,twtoken,twsecret) VALUES ('".$_POST['twmail']."','".$_SESSION['twuid']."','".$_SESSION['oauth_token']."','".$_SESSION['oauth_token_secret']."')";
		mysql_query($sql) or die(mysql_error());
	}
	unset($_SESSION['oauth_token']);
	unset($_SESSION['oauth_token_secret']);
	$sql="SELECT * FROM users WHERE twuid='".$_SESSION['twuid']."'";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if($row['fbuid']!='')
		$_SESSION['fbuid']=$row['fbuid'];
	if($row['gpuid']!='')
		$_SESSION['gpuid']=$row['gpuid'];
	if($row['email']!='')
		$_SESSION['email']=$row['email'];
	echo '<meta http-equiv="Refresh" content="1; url=http://announcemewhen.com/login.php">';
	
}
else{
	echo '
		<h1>It seems that you signed up with Twitter!</h1><h4>Unfortunately, we have no way to send you emails right now,<br>So please enter your preffered email address below.<br>If you already have an account on our website, we will take care to merge these two(if the emails match).<br>We promise we won\'t send you spam or share your email with anyone else</h4> 
			<form method = "post" action = "twittermail.php"> 
				<input type = "text" name = "twmail" value = ""> 
				<br> 
				<input type = "submit" value = "Submit"> 
			</form> 
		';
}





?>