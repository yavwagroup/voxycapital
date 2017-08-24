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
$trade_id = protect($_GET['trade_id']);
$query = $db->query("SELECT * FROM btc_trades WHERE id='$trade_id'");
if($query->num_rows>0) {
	$row = $query->fetch_assoc();
	if($row['type'] == "sell") {
												if($row['status'] == "0") { 
													$status =  '<span class="text text-info">'.$lang[status_0].'</span>';
												} elseif($row['status'] == "1") {
													$status =  '<span class="text text-info">'.$lang[status_1_1].'</span>';
												} elseif($row['status'] == "2") {
													$status = '<span class="text text-info">'.$lang[status_2_1].'</span>';
												} elseif($row['status'] == "3") {
													$status = '<span class="text text-info">'.$lang[status_3_1].'</span>';
												} elseif($row['status'] == "4") {
													$status = '<span class="text text-danger">'.$lang[status_4].'</span>';
												} elseif($row['status'] == "5") {
													$status = '<span class="text text-danger">'.$lang[status_5].'</span>';
												} elseif($row['status'] == "6") {
													$status = '<span class="text text-danger">'.$lang[status_6].'</span>';
												} elseif($row['status'] == "7") {
													$status = '<span class="text text-success">'.$lang[status_7].'</span>';
												} else {
													$status = '<span class="text text-default">Unknown</span>';
												}
											} else {
												if($row['status'] == "0") { 
													$status =  '<span class="text text-info">'.$lang[status_0].'</span>';
												} elseif($row['status'] == "1") {
													$status =  '<span class="text text-info">'.$lang[status_1_2].'</span>';
												} elseif($row['status'] == "2") {
													$status = '<span class="text text-info">'.$lang[status_2_2].'</span>';
												} elseif($row['status'] == "3") {
													$status = '<span class="text text-info">'.$lang[status_3_2].'</span>';
												} elseif($row['status'] == "4") {
													$status = '<span class="text text-danger">'.$lang[status_4].'</span>';
												} elseif($row['status'] == "5") {
													$status = '<span class="text text-danger">'.$lang[status_5].'</span>';
												} elseif($row['status'] == "6") {
													$status = '<span class="text text-danger">'.$lang[status_6].'</span>';
												} elseif($row['status'] == "7") {
													$status = '<span class="text text-success">'.$lang[status_7].'</span>';
												} else {
													$status = '<span class="text text-default">Unknown</span>';
												}
											}
											
	$data['status'] = 'success';
	$data['msg'] = $status;
} else {
	$data['status'] = 'error';
	$data['msg'] = 'error';
}
echo json_encode($data);
?>
