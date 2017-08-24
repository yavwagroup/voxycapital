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
$ext = array('jpg','jpeg','pdf','png'); 
	$file_ext = end(explode('.',$_FILES['uploadFile']['name'])); 
	$file_ext = strtolower($file_ext); 
	if($_FILES['uploadFile']['name']) { 
	  if(in_array($file_ext,$ext)) {
			$uid = $_SESSION['btc_uid'];
			$trade_id = protect($_GET['trade_id']);
			$path = 'uploads/attachments/'.$_SESSION[btc_uid].'_'.time().'_attachment.'.$file_ext;
			@move_uploaded_file($_FILES['uploadFile']['tmp_name'], $path); 
			$time = time();
			$insert = $db->query("INSERT btc_trades_messages (uid,trade_id,readed,message,attachment,time) VALUES ('$uid','$trade_id','0','$path','1','$time')");
	  }
	}
?>