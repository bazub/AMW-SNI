<?php
session_start();
$id=$_SESSION['twuid'];
mysql_connect('annosocusers.db.10918050.hostedresource.com','annosocusers','*****');
mysql_select_db('annosocusers');
$sql="SELECT * FROM users WHERE twuid='".$id."'";
$res=mysql_query($sql);
$row=mysql_fetch_array($res);
if($row['gpmail']=='' AND $row['email']=='' AND $row['fbuid']==''){
    $sql="DELETE FROM users WHERE twuid='".$id."'";
    mysql_query($sql);
    session_destroy();
}
else{
	$sql="UPDATE users SET twuid='', twtoken='', twsecret='', twmail='' WHERE twuid='".$id."'";
	mysql_query($sql) or die(mysql_error());
	unset($_SESSION['twuid']);
}
echo '<h3>As there is no way to automaticaly remove the authorization from Twitter, we must ask you to revoke AnnouceMeWhen\'s access manually.<br>
	You can do that by visiting this <a href="https://twitter.com/settings/applications">link.</a><br>
	Thank you for your understanding.';
echo '<meta http-equiv="Refresh" content="10; url=http://announcemewhen.com">';
?>