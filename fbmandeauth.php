<?php
session_start();

$id=$_SESSION['fbuid'];
mysql_connect('annosocusers.db.10918050.hostedresource.com','annosocusers','*****');
mysql_select_db('annosocusers');
$sql="SELECT * FROM users WHERE fbuid='".$id."'";
$res=mysql_query($sql);
$row=mysql_fetch_array($res);

// Send the DELETE request to FB (actually a POST request with a 'method=delete' parameter 
$url = 'https://graph.facebook.com/me/permissions';
$data = array('access_token' => $row['fbtoken'], 'method' => 'delete');
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

// Delete user & "Log out"
if($row['gpmail']=='' AND $row['email']==''){
    $sql="DELETE FROM users WHERE fbuid='".$id."'";
    mysql_query($sql);
    session_destroy();
}
// Update user & fb session
else{
	$sql="UPDATE users SET fbuid='', fbtoken='', fbexpire='', fbmail='' WHERE fbuid='".$id."'";
	mysql_query($sql);
	unset($_SESSION['fbuid']);
}
echo '<meta http-equiv="Refresh" content="1; url=http://announcemewhen.com">';


?>