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
include(getLanguage($settings['url'],null,2));
$uid = $_SESSION['btc_uid'];
$message = protect($_POST['message']);
$time = time();
$trade_id = protect($_GET['trade_id']);
if(empty($message) or empty($trade_id) or empty($uid)) { 
	$data['status'] = 'error';
	$data['msg'] = 'ERROR';
} else {
	$insert = $db->query("INSERT btc_trades_messages (uid,trade_id,readed,message,time) VALUES ('$uid','$trade_id','0','$message','$time')");
	$data['status'] = 'success'; 
	$data['msg'] = '<div style="font-size:14px;">
		<b><a href="'.$settings[url].'user/'.idinfo($uid,"username").'">'.idinfo($uid,"username").'</a></b>: '.$message.'<br/>
		<span class="text text-muted" style="font-size:11px;">'.timeago($time).'</span>
	</div>
	<hr/>';
}
echo json_encode($data);
?>
