<?php
session_start();

$id=$_SESSION['gpuid'];
mysql_connect('annosocusers.db.10918050.hostedresource.com','annosocusers','*****');
mysql_select_db('annosocusers');
$sql="SELECT * FROM users WHERE gpuid='".$id."'";
$res=mysql_query($sql);
$row=mysql_fetch_array($res);

$result=file_get_contents('https://accounts.google.com/o/oauth2/revoke?token='.$row['gptoken'].'');
if($row['fbmail']=='' AND $row['email']==''){
    $sql="DELETE FROM users WHERE gpuid='".$id."'";
    mysql_query($sql);
    session_destroy();
}
// Update user & fb session
else{
	$sql="UPDATE users SET gpuid='', gptoken='', gprefresh='', gpmail=''  WHERE gpuid='".$id."'";
	mysql_query($sql);
	unset($_SESSION['gpuid']);
}
echo '<meta http-equiv="Refresh" content="1; url=http://announcemewhen.com">';


?>