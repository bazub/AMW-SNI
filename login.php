<?php
session_start();
?>
<html>

<style type="text/css">
    a.fbLogIn{
		display: block;
		height: 53px;
		width: 216px;
		background-image:url('fb_connect_bn.png');
		margin-top:11px;
		margin-right:10px;
		background-position:0px 0px;
	}
	a.fbLogIn:hover{
		margin-top:11px;
		margin-right:10px;
		background-position:-252px 0px;
	}
	a.fbLogOut{
		display: block;
		height: 53px;
		width: 216px;
		margin-right:0px;
		background-image:url('fb_connect_bn.png');
		background-position: 0px -69px;
	}
	a.fbLogOut:hover{
		background-position: -252px -69px;
		margin-right:10px;
	}
	a.gpLogIn{
		display: block;
		height: 53px;
		width: 216px;
		background-image:url('gp_connect_bn.png');
		margin-top:11px;
		margin-right:10px;
		background-position:0px 0px;
	}
	a.gpLogIn:hover{
		margin-top:11px;
		margin-right:10px;
		background-position:-252px 0px;
	}
	a.gpLogOut{
		display: block;
		height: 53px;
		width: 216px;
		margin-right:0px;
		background-image:url('gp_connect_bn.png');
		background-position: 0px -69px;
	}
	a.gpLogOut:hover{
		background-position: -252px -69px;
		margin-right:10px;
	}
	a.twLogIn{
		display: block;
		height: 53px;
		width: 216px;
		background-image:url('tw_connect_bn.png');
		margin-top:11px;
		margin-right:10px;
		background-position:0px 0px;
	}
	a.twLogIn:hover{
		margin-top:11px;
		margin-right:10px;
		background-position:-252px 0px;
	}
	a.twLogOut{
		display: block;
		height: 53px;
		width: 216px;
		margin-right:0px;
		background-image:url('tw_connect_bn.png');
		background-position: 0px -69px;
	}
	a.twLogOut:hover{
		background-position: -252px -69px;
		margin-right:10px;
	}

</style>


<?php

if(isset($_SESSION['fbuid'])){
	echo '
		<a class="fbLogOut" href="http://announcemewhen.com/fbmandeauth.php"></a>
	';
}
else{
	echo '
		<a class="fbLogIn" href="http://announcemewhen.com/fblogin.php"></a>
	';
}

if(isset($_SESSION['gpuid'])){
	echo '
		<a class="gpLogOut" href="http://announcemewhen.com/gpmandeauth.php"></a>
	';
}
else{
	echo '
		<a class="gpLogIn" href="http://announcemewhen.com/gplogin.php"></a>
	';
}

if(isset($_SESSION['twuid'])){
	echo '
		<a class="twLogOut" href="http://announcemewhen.com/twmandeauth.php"></a>
	';
}
else{
	echo '
		<a class="twLogIn" href="http://announcemewhen.com/twlogin.php"></a>
	';
}

?>





  
  
</html>