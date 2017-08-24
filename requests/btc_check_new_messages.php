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
$trade_id = protect($_GET['trade_id']);
$query = $db->query("SELECT * FROM btc_trades_messages WHERE uid !='$uid' and trade_id='$trade_id' and readed='0' ORDER BY id DESC");
if($query->num_rows>0) {
	while($row = $query->fetch_assoc()) {
		if($row['uid'] == $_SESSION['btc_uid']) {
			$data['status'] = 'error';
			$data['msg'] = 'User is the some'; 
		} else {
			$data['status'] = 'success'; 
			if($row['attachment'] == "1") {
				$filename = basename($row['message']);
				$data['msg'] = '<div style="font-size:14px;">
				<b><a href="'.$settings[url].'user/'.idinfo($row[uid],"username").'">'.idinfo($row[uid],"username").'</a></b> attach file<br/>
				<i class="fa fa-file-o"></i> <a href="'.$settings[url].$row[message].'" target="_blank">'.$filename.'</a><br/>
				<span class="text text-muted" style="font-size:11px;">'.timeago($row[time]).'</span>
			</div>
			<hr/>';
			} else {
			$data['msg'] = '<div style="font-size:14px;">
				<b><a href="'.$settings[url].'user/'.idinfo($row[uid],"username").'">'.idinfo($row[uid],"username").'</a></b>: '.$row[message].'<br/>
				<span class="text text-muted" style="font-size:11px;">'.timeago($row[time]).'</span>
			</div>
			<hr/>';
			}
			$update = $db->query("UPDATE btc_trades_messages SET readed='1' WHERE id='$row[id]'");
		}
	}
} else {
	$data['status'] = 'error';
	$data['msg'] = 'No data';
}
echo json_encode($data);
?>
