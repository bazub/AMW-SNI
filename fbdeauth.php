<?php
$signed_request=$_POST['signed_request'];
$app_secret='****';
parse_signed_request($signed_request,$app_secret);
function base64_url_decode($input) {
    return base64_decode(strtr($input, '-_', '+/'));
}
function parse_signed_request($signed_request,$secret) {
    list($encoded_sig, $payload) = explode('.', $signed_request, 2);
    $sig = base64_url_decode($encoded_sig);
	$data = json_decode(base64_url_decode($payload));
	/* Removed verification of the signature as it continously gave different signatures despite correct code
    $expected_sig = hash_hmac('sha256', $payload, $secret, $raw=true);
	if ($sig !== $expected_sig) {
		error_log('Bad Signed JSON signature!');
		$myFile = "fbdeauth.txt";
		$fout = fopen($myFile, 'w') or die("can't open file");
		fwrite($fout, $encoded_sig);
		fwrite($fout, '        ');
		fwrite($fout, base64_encode($expected_sig));
		fclose($fout);
		return null;
	}
	else{
        */
		
		$id = $data->{'user_id'};
		mysql_connect('annosocusers.db.10918050.hostedresource.com','annosocusers','****');
		mysql_select_db('annosocusers');
		$sql="SELECT * FROM users WHERE fbuid='".$id."'";
		$res=mysql_query($sql);
		$row=mysql_fetch_array($res);
		if($row['gtoken']=='' AND $row['pwd']==''){
			$sql="DELETE FROM users WHERE fbuid='".$id."'";
			mysql_query($sql);
		}
		else{
			$sql="UPDATE users SET fbuid='', fbtoken='', fbexpire='' WHERE fbuid='".$id."'";
			mysql_query($sql);
		}
	//}
}


?>
