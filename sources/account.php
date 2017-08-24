<?php 
if(!checkSession()) { $redirect = $settings['url']."login"; header("Location:$redirect"); } 
$b = protect($_GET['b']);
if($b == "wallet") {
	include("account/wallet.php");
} elseif($b == "transactions") {	
	include("account/transactions.php");
}  elseif($b == "trades") {	
	include("account/trades.php");
} elseif($b == "advertisements") {	
	include("account/advertisements.php");
} elseif($b == "settings") {	
	include("account/settings.php");
} elseif($b == "verification") {	
	include("account/verification.php");
} else {
	header("Location: $settings[url]");
}
?>