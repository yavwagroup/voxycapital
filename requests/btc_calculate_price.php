<?php
ob_start();
session_start();
error_reporting(0);
include("../includes/config.php");
$db = new mysqli($CONF['host'], $CONF['user'], $CONF['pass'], $CONF['name']);
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
$db->set_charset("utf8");
$settingsQuery = $db->query("SELECT * FROM btc_settings ORDER BY id DESC LIMIT 1");
$settings = $settingsQuery->fetch_assoc();
include("../includes/functions.php");
//include(getLanguage($settings['url'],null,2));
$amount = protect($_GET['amount']);
$currency = protect($_GET['currency']);
if(is_numeric($amount)) {
	if($currency == "USD") {
		$btcprice = get_current_bitcoin_price();
		$com = $amount;
		$com2 = ($btcprice * $com) / 100;
		$amm = $btcprice - $com2;
		echo 'Your Bitcoin price: '.ceil($amm).' '.$currency;
	} else {
		$btcprice = get_current_bitcoin_price();
		$com = $amount;
		$com2 = ($btcprice * $com) / 100;
		$com3 = $btcprice - $com2;
		$amm = currencyConvertor($com3,"USD",$currency);
		echo 'Your Bitcoin price: '.ceil($amm).' '.$currency.' ('.$com3.' USD)';
	}
}
?>