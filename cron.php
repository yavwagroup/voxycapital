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
//include(getLanguage($settings['url'],null,null));

$query = $db->query("SELECT * FROM btc_users ORDER BY id");
if($query->num_rows>0) {
	while($row = $query->fetch_assoc()) {
		btc_update_balance($row['id']);
		btc_update_transactions($row['id']);
		btc_delete_fee_transactions($row['id']);
	}
}
btc_get_bitcoin_prices();
btc_check_expired_trades();
mysqli_close($db);
?>