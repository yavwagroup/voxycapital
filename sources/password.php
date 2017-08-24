<?php 
if(checkSession()) { $redirect = $settings['url']."account/wallet"; header("Location:$redirect"); } 
$b = protect($_GET['b']);
if($b == "reset") {
	include("password/reset.php");
} elseif($b == "change") {	
	include("password/change.php");
} else {
	header("Location: $settings[url]");
}
?>