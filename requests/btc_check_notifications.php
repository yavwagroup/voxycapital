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
$uid = protect($_GET['uid']);
if(empty($uid)) {
	$data['status'] = 'error';
	$data['msg'] = 'Not selected user.'; 
} else {
	$query = $db->query("SELECT * FROM btc_users_notifications WHERE uid='$uid' and notified='0'");
	if($query->num_rows>0) {
		while($row = $query->fetch_assoc()) {
			$data['status'] = 'success';
			$lang_new_trade_request = str_ireplace("%btc_amount%",tradeinfo($row[trade_id],"btc_amount"),$lang['new_trade_request']);
			$data['msg'] = $lang_new_trade_request;
			if(tradeinfo($row['trade_id'],"type") == "buy") {
				$adid = tradeinfo($row['trade_id'],"ad_id");
				$pm = adinfo($adid,"payment_method");
				$pm = str_ireplace(" ","-",$pm);
				$link = $settings['url']."trade/".$pm."-to-Bitcoin/".$row['trade_id'];
			} else {
				$adid = tradeinfo($row['trade_id'],"ad_id");
				$pm = adinfo($adid,"payment_method");
				$pm = str_ireplace(" ","-",$pm);
				$link = $settings['url']."trade/Bitcoin-to-".$pm."/".$row['trade_id'];
			}
			$data['link'] = $link;
			$update = $db->query("UPDATE btc_users_notifications SET notified='1' WHERE id='$row[id]'");
		}
	} else {
		$data['status'] = 'error';
		$data['msg'] = 'No have notifications'; 
	}
}
echo json_encode($data);
?>