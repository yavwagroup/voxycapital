<?php
ob_start();
session_start();
error_reporting(0);
if(file_exists("./install.php")) {
	header("Location: ./install.php");
} 
include("includes/config.php");
$db = new mysqli($CONF['host'], $CONF['user'], $CONF['pass'], $CONF['name']);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
$db->set_charset("utf8");
$settingsQuery = $db->query("SELECT * FROM btc_settings ORDER BY id DESC LIMIT 1");
$settings = $settingsQuery->fetch_assoc();
include("includes/block_io.php");
include("includes/functions.php");
include(getLanguage($settings['url'],null,null));

if(isset($_GET['refid'])) {
	$_SESSION['refid'] = protect($_GET['refid']);
	header("Location: $settings[url]");
}

if(checkSession()) {	
	update_activity($_SESSION['btc_uid']);
	btc_delete_fee_transactions($_SESSION['btc_uid']);
}

include("sources/header.php");
$a = protect($_GET['a']);
switch($a) {
	case "account": include("sources/account.php"); break;
	case "login": include("sources/login.php"); break;
	case "register": include("sources/register.php"); break;
	case "password": include("sources/password.php"); break;
	case "post-ad": include("sources/post_ad.php"); break;
	case "email_verify": include("sources/email_verify.php"); break;
	case "affiliate": include("sources/affiliate.php"); break;
	case "contact": include("sources/contact.php"); break;
	case "page": include("sources/page.php"); break;
	case "buy_bitcoins": include("sources/buy_bitcoins.php"); break;
	case "sell_bitcoins": include("sources/sell_bitcoins.php"); break;
	case "bitcoin_to": include("sources/bitcoin_to.php"); break;
	case "to_bitcoin": include("sources/to_bitcoin.php"); break;
	case "user": include("sources/user.php"); break;
	case "search": include("sources/search.php"); break;
	case "ad": include("sources/ad.php"); break;
	case "trade": include("sources/trade.php"); break;
	case "faq": include("sources/faq.php"); break;
	case "logout": 
		unset($_SESSION['btc_uid']);
		unset($_COOKIE['bitcoinsmarket_uid']);
		setcookie("bitcoinsmarket_uid", "", time() - (86400 * 30), '/'); // 86400 = 1 day
		session_unset();
		session_destroy();
		header("Location: $settings[url]");
	break;
	default: include("sources/homepage.php");
}
include("sources/footer.php");
mysqli_close($db);
?>