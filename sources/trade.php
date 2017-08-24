<?php
$b = protect($_GET['b']);
$id = protect($_GET['id']);
if($b == "cancel") {
	$query = $db->query("SELECT * FROM btc_trades WHERE id='$id' and uid='$_SESSION[btc_uid]' or id='$id' and trader='$_SESSION[btc_uid]'");
	if($query->num_rows==0) { header("Location: $settings[url]"); }
	$row = $query->fetch_assoc();
	?>
	<div class="container-fluid page-title">
			<div class="row blue-banner">
            	<div class="container main-container">
                	<div class="col-lg-12 col-md-12 col-sm-12">
                		<h3 class="white-heading"><?php echo $lang['cancel_trade']; ?></h3>
                    </div>
                </div>
            </div> 
        </div> 
  	 <!--header section -->
	<!-- full width section -->
    	<div class="container-fluid white-bg">
        	<div class="row">
            	<div class="container">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="content">
					<?php
					
					if($row['status']>1 or $row['status'] == "0") {
						echo error($lang['error_47']);
					} else {
						$query = $db->query("SELECT * FROM btc_trades WHERE id='$row[id]'");
					$row = $query->fetch_assoc();
						$update = $db->query("UPDATE btc_trades SET status='5' WHERE id='$row[id]'");
						echo info($lang['info_2']);
					}
					?>
					<script type="text/javascript">
					function redirect() {
						window.location.href='<?php echo $settings['url']; ?>account/trades';
					}
					setTimeout(redirect,5000);
					</script>
					
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php
} elseif($b == "report") {
	$query = $db->query("SELECT * FROM btc_trades WHERE id='$id' and uid='$_SESSION[btc_uid]' or id='$id' and trader='$_SESSION[btc_uid]'");
	if($query->num_rows==0) { header("Location: $settings[url]"); }
	$row = $query->fetch_assoc();
	if(adinfo($row['ad_id'],"type") == "buy") {
		$pm = adinfo($row['ad_id'],"payment_method");
		$pm = str_ireplace(" ","-",$pm);
		$adlink = $settings['url']."ad/Bitcoin-to-".$pm."/".$row['ad_id']; 
	} else {
		$pm = adinfo($row['ad_id'],"payment_method");
		$pm = str_ireplace(" ","-",$pm);
		$adlink = $settings['url']."ad/".$pm."-to-Bitcoin/".$row['ad_id']; 
	}
	?>
	<div class="container-fluid page-title">
			<div class="row blue-banner">
            	<div class="container main-container">
                	<div class="col-lg-12 col-md-12 col-sm-12">
					<h3 class="white-heading"><?php echo $lang['report_trade']; ?></h3>
					</div>
                </div>
            </div> 
        </div> 
  	 <!--header section -->
	 <!-- full width section -->
    	<div class="container-fluid white-bg">
        	<div class="row">
            	<div class="container">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="content">
						<div class="container">
							<div class="col-md-12" style="margin-top:10px;margin-bottom:30px;"	>	
								<div class="row">
									<div class="col-md-12">
										<span style="font-size:35px;font-weight:bold;"><?php echo $lang['ttrade']; ?> #<?php echo $row['id']; ?> <small><?php echo $lang['from_advertisement']; ?> <a href="<?php echo $adlink; ?>" style="color:#fff;">#<?php echo $row['ad_id']; ?></a>, <?php echo $lang['bitcoin_price']; ?> <?php echo $row['btc_price']; ?> <?php echo adinfo($row['ad_id'],"currency"); ?>/BTC</span><br/>
										<span style="font-size:25px;"><?php echo $lang['trade_amount']; ?>: <b><?php echo $row['amount']; ?> <?php echo adinfo($row['ad_id'],"currency"); ?></b> (<?php echo $row['btc_amount']; ?> BTC)</span>
									</div>
								</div>
							</div>
						</div>
					<br>
					<?php 
					if(isset($_POST['btc_report'])) {
						$content = protect($_POST['content']);
						$time = time();
						if(empty($content)) { echo error($lang['error_26']); }
						else {
							$insert = $db->query("INSERT btc_trades_reports (uid,trade_id,content,status,time) VALUES ('$_SESSION[btc_uid]','$row[id]','$content','0','$time')");
							$getreport = $db->query("SELECT * FROM btc_trades_reports WHERE uid='$_SESSION[btc_uid]' ORDER BY id DESC LIMIT 1");
							$report = $getreport->fetch_assoc();
							echo success("$lang[success_5] $report[id]");
						}
					}
					?>
					<form action="" method="POST">
						<div class="form-group">
							<label><?php echo $lang['your_report']; ?></label>
							<textarea class="form-control" name="content" rows="10"></textarea>
						</div>
						<button type="submit" class="btn btn-primary" name="btc_report"><i class="fa fa-check"></i> <?php echo $lang['btn_submit']; ?></button>
					</form>
					</div>
					</div>
				</div>
			</div>
		</div>
	<?php
} elseif($b == "leave-feedback") {
$query = $db->query("SELECT * FROM btc_trades WHERE id='$id' and uid='$_SESSION[btc_uid]' or id='$id' and trader='$_SESSION[btc_uid]'");
	if($query->num_rows==0) { header("Location: $settings[url]"); }
	$row = $query->fetch_assoc();
	if($row['status'] !== "7") { $redirect = $settings['url']."account/trades"; header("Location: $redirect"); }
	$check_feedback = $db->query("SELECT * FROM btc_users_ratings WHERE trade_id='$row[id]' and author='$_SESSION[btc_uid]'");
	if($check_feedback->num_rows>0) {  $redirect = $settings['url']."account/trades"; header("Location: $redirect"); }
	?>
		<div class="container-fluid page-title">
			<div class="row blue-banner">
            	<div class="container main-container">
                	<div class="col-lg-12 col-md-12 col-sm-12">
					<h3 class="white-heading"><?php echo $lang['leave_feedback']; ?></h3>
					</div>
                </div>
            </div> 
        </div> 
  	 <!--header section -->
	 <!-- full width section -->
    	<div class="container-fluid white-bg">
        	<div class="row">
            	<div class="container">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="content">
						<div class="container">
							<div class="col-md-12" style="margin-top:10px;margin-bottom:30px;"	>	
								<div class="row">
									<div class="col-md-12">
										<span style="font-size:35px;font-weight:bold;"><?php echo $lang['ttrade']; ?> #<?php echo $row['id']; ?> <small><?php echo $lang['from_advertisement']; ?> <a href="<?php echo $adlink; ?>" style="color:#fff;">#<?php echo $row['ad_id']; ?></a>, <?php echo $lang['bitcoin_price']; ?> <?php echo $row['btc_price']; ?> <?php echo adinfo($row['ad_id'],"currency"); ?>/BTC</span><br/>
										<span style="font-size:25px;"><?php echo $lang['trade_amount']; ?>: <b><?php echo $row['amount']; ?> <?php echo adinfo($row['ad_id'],"currency"); ?></b> (<?php echo $row['btc_amount']; ?> BTC)</span>
									</div>
								</div>
							</div>
						</div>
					<br>
					<?php 
					$hide_form=0;
					if(isset($_POST['btc_feedback'])) {
						$type = protect($_POST['type']);
						$content = protect($_POST['content']);
						$trade_id = protect($_POST['trade_id']);
						if($row['uid'] !== $_SESSION['btc_uid']) { $uid = $row['uid']; } elseif($row['trader'] !== $_SESSION['btc_uid']) { $uid = $row['trader']; } else { } 
						$time = time();
						$author = $_SESSION['btc_uid'];
						if(empty($type)) { echo error($lang['error_27']); }
						elseif(empty($content)) { echo error($lang['error_28']); }
						else {
							$insert = $db->query("INSERT btc_users_ratings (uid,type,trade_id,comment,author,time) VALUES ('$uid','$type','$row[id]','$content','$author','$time')");
							echo success($lang['success_6']);
							$hide_form = 1;
						}
					}
					
					if($hide_form == "0") {
					?>
					<form action="" method="POST">
						<div class="form-group">
							<label><?php echo $lang['choose_feedback_type']; ?></label>
							<div class="radio">
							  <label>
								<input type="radio" name="type" value="1">
								<span class="text text-success"><i class="fa fa-smile-o"></i> <?php echo $lang['positive']; ?></span>
							  </label>
							</div>
							<div class="radio">
							  <label>
								<input type="radio" name="type" value="2">
								<span class="text text-warning"><i class="fa fa-meh-o"></i> <?php echo $lang['neutral']; ?></span>
							  </label>
							</div>
							<div class="radio">
							  <label>
								<input type="radio" name="type" value="3">
								<span class="text text-danger"><i class="fa fa-frown-o"></i> <?php echo $lang['negative']; ?></span>
							  </label>
							</div>
						</div>
						<div class="form-group">
							<label>Your feedback</label>
							<textarea class="form-control" name="content" rows="10" placeholder="<?php echo $lang['leave_feedback_for']; ?> <?php if($row['uid'] !== $_SESSION['btc_uid']) { echo idinfo($row['uid'],"username"); } elseif($row['trader'] !== $_SESSION['btc_uid']) { echo idinfo($row['trader'],"username"); } else { } ?>.."></textarea>
						</div>
						<button type="submit" class="btn btn-primary" name="btc_feedback"><i class="fa fa-check"></i> <?php echo $lang['btn_submit']; ?></button>
					</form>
					<?php
					}
					?>
					</div>
					</div>
				</div>
			</div>
		</div>
	<?php
} elseif($b == "process") {
	$query = $db->query("SELECT * FROM btc_trades WHERE id='$id' and uid='$_SESSION[btc_uid]' or id='$id' and trader='$_SESSION[btc_uid]'");
	if($query->num_rows==0) { header("Location: $settings[url]"); }
	$row = $query->fetch_assoc();
							$minutes = $row['timeout']-time();
						$minutes = $minutes / 60;
						$minutes = ceil($minutes);
						if($minutes < 0) { $minutes = 0; }
						
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
											
	if(adinfo($row['ad_id'],"type") == "buy") {
		$pm = adinfo($row['ad_id'],"payment_method");
		$pm = str_ireplace(" ","-",$pm);
		$adlink = $settings['url']."ad/Bitcoin-to-".$pm."/".$row['ad_id']; 
	} else {
		$pm = adinfo($row['ad_id'],"payment_method");
		$pm = str_ireplace(" ","-",$pm);
		$adlink = $settings['url']."ad/".$pm."-to-Bitcoin/".$row['ad_id']; 
	}
	if($row['type'] == "sell") {
		if($row['uid'] == $_SESSION['btc_uid']) {
		// Client side when he/she sell bitcoins
		?>
	<div class="container-fluid page-title">
			<div class="row blue-banner">
            	<div class="container main-container">
                	<div class="col-lg-12 col-md-12 col-sm-12">
								<span style="color:#fff;font-size:35px;font-weight:bold;"><?php echo $lang['ttrade']; ?> #<?php echo $row['id']; ?> <small><?php echo $lang['from_advertisement']; ?> <a href="<?php echo $adlink; ?>" style="color:#fff;">#<?php echo $row['ad_id']; ?></a>, <?php echo $lang['bitcoin_price']; ?> <?php echo $row['btc_price']; ?> <?php echo adinfo($row['ad_id'],"currency"); ?>/BTC</span><br/>
								<span style="color:#fff;font-size:25px;"><?php echo $lang['trade_amount']; ?>: <b><?php echo $row['amount']; ?> <?php echo adinfo($row['ad_id'],"currency"); ?></b> (<?php echo $row['btc_amount']; ?> BTC)</span>
							 </div>
                </div>
            </div> 
        </div> 
  	 <!--header section -->
	 <!-- full width section -->
    	<div class="container-fluid white-bg">
        	<div class="row">
            	<div class="container">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="content">
						<div class="col-lg-12">
				<?php
				if(isset($_POST['btc_release_bitcoins'])) {
					if($row['released_bitcoins'] == "0") {
						if($minutes !== "0") {
							$form = '<div class="alert alert-warning" style="font-size:18px;"><form action="" method="POST">
								<p>'.$lang[are_you_sure_release_bitcoins_1].' <a href="'.$settings[url].'user/'.idinfo($row[trader],"username").'">'.idinfo($row[trader],"username").'</a>?</p>
								<small>'.$lang[this_action_can_be_undo].'</small>
								<br/><br/>
								<button type="submit" class="btn btn-success" name="btc_relaese_bitcoins_confirmed"><i class="fa fa-check"></i> '.$lang[btn_yes_release_bitcoins].'</button> 
								<a href="" class="btn btn-danger"><i class="fa fa-times"></i> '.$lang[btn_no].'</a>
							</form>
							</div>';
							echo $form;
						}
					}	
				}
				
				if(isset($_POST['btc_relaese_bitcoins_confirmed'])) {
					if($minutes !== "0") {
						if($row['released_bitcoins'] !== "1") {
						$update = $db->query("UPDATE btc_trades SET status='7',released_bitcoins='1' WHERE id='$row[id]'");
						$uaddress = walletinfo($row['uid'],"address");
						$taddress = walletinfo($row['trader'],"address");
						$lid = walletinfo($_SESSION['btc_uid'],"lid");
						if (strpos($settings['sell_comission'],'%') !== false) { 
							$bamount = $row['btc_amount'];
							$explode = explode("%",$settings['sell_comission']);
							$fee_percent = $explode[0];
							$new_amount = ($bamount * $fee_percent) / 100;
							$new_amount = round($new_amount,8);
							//$fee_amount = $bamount-$new_amount;
							$bamount = $fee_amount;
							$admincomission = $new_amount;
						} else {
							$admincomission = $settings['sell_comission'];
						}
						$license_query = $db->query("SELECT * FROM btc_blockio_licenses WHERE id='$lid' ORDER BY id");
						$license = $license_query->fetch_assoc();
						$apiKey = $license['license'];
						$pin = $license['secret_pin'];
						$version = 2; // the API version
						$block_io = new BlockIo($apiKey, $pin, $version);
						$withdrawal = $block_io->withdraw_from_addresses(array('amounts' => $row[btc_amount], 'from_addresses' => $uaddress, 'to_addresses' => $taddress));
						$withdrawal = $block_io->withdraw_from_addresses(array('amounts' => $admincomission, 'from_addresses' => $uaddress, 'to_addresses' => $license[address]));
						echo success($lang['success_7']);
						$query = $db->query("SELECT * FROM btc_trades WHERE id='$row[id]'");
						$row = $query->fetch_assoc();
						}
					}
				}
				
				if(isset($_POST['btc_cancel_trade'])) {
					if($row['status']>1 or $row['status'] == "0") {
						echo error($lang['error_47']);
					} else {
					$update = $db->query("UPDATE btc_trades SET status='5' WHERE id='$row[id]'");
					$query = $db->query("SELECT * FROM btc_trades WHERE id='$row[id]'");
					$row = $query->fetch_assoc();
					echo info($lang['info_3']);
					}
				}
				?>
			</div>
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-body">
						<b><?php echo $lang['status']; ?>:</b> <span id="trade_status_<?php echo $row['id']; ?>"><?php echo $status; ?></span>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-body">
						<p style="font-size:16px;">
						<?php
						$lang_trade_info_1 = str_ireplace("%payment_method%",adinfo($row['ad_id'],"payment_method"),$lang['trade_info_1']);
						echo $lang_trade_info_1;
						?></p>
						<p style="font-size:14px;" class="text text-danger"><?php echo $lang['trade_info_2']; ?></p>
						<p><?php echo $lang['trade_info_3']; ?></p>
						<br>
						<form action="" method="POST">
							<?php if($row['status'] < 3) { ?>
							<?php if($row['released_bitcoins'] == "0") { ?>
							<?php if($minutes !== "0") { ?>
							<button type="submit" class="btn btn-success" name="btc_release_bitcoins"><i class="fa fa-check"></i> <?php echo $lang['btn_release_bitcoins']; ?></button>
							<button type="submit" class="btn btn-danger" name="btc_cancel_trade" id="btc_cancel_trade"><i class="fa fa-times"></i> <?php echo $lang['btn_cancel_trade']; ?></button>
							<?php } ?>
							<?php } ?>
							<?php } ?>
							<a href="<?php echo $settings['url']; ?>report/trade/<?php echo $row['id']; ?>" class="btn btn-warning"><i class="fa fa-flag"></i> <?php echo $lang['btn_report_trade']; ?></a>
							<?php if($row['status'] == "7") { ?>
								<?php
								$check_feedback = $db->query("SELECT * FROM btc_users_ratings WHERE trade_id='$row[id]' and author='$_SESSION[btc_uid]'");
								if($check_feedback->num_rows==0) {
									?>
									<a href="<?php echo $settings['url']; ?>leave-feedback/trade/<?php echo $row['id']; ?>" class="btn btn-info"><i class="fa fa-comment"></i> <?php echo $lang['btn_leave_feedback']; ?></a>
									<?php
								}
								?>
							<?php } ?>
						</form>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-body">
						<?php
						if($minutes == 0) {
						?>
						<?php echo $lang['trade_info_4']; ?>
						<?php
						} else {
						?>
						<?php
						$lang_trade_info_5 = str_ireplace("%minutes%",$minutes,$lang['trade_info_5']);
						echo $lang_trade_info_5;
						?>
						<?php 
						}
						?>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<script type="text/javascript">
							$(function(){
								var btn = document.getElementById('uploadBtn');
								var trade_id = '<?php echo $row['id']; ?>';
								var uploader = new ss.SimpleUpload({
									button: btn,
									url: '<?php echo $settings['url']; ?>upload.php?trade_id=<?php echo $row['id']; ?>',
									name: 'uploadFile',
									onComplete: function( filename, response ) {
										btc_check_new_file_messages('<?php echo $_SESSION['btc_uid']; ?>','<?php echo $row['id']; ?>');
									  },
									   onError: function() {
										btc_check_new_file_messages('<?php echo $_SESSION['btc_uid']; ?>','<?php echo $row['id']; ?>');
									  }
								});
							});
							function btc_int_cnm() {
								btc_check_new_messages('<?php echo $_SESSION['btc_uid']; ?>','<?php echo $row['id']; ?>');
								btc_check_trade_status('<?php echo $row['id']; ?>');
							}
							
							setInterval(btc_int_cnm,3000);
						</script>
						<h3><?php echo $lang['chat']; ?></h3>
						<form id="trade_chat_form_<?php echo $row['id']; ?>">
							<div class="form-group">
								<textarea class="form-control" name="message" rows="3" placeholder="<?php echo $lang['write_message_to_trader']; ?>"></textarea>
							</div>
							<button type="button" class="btn btn-warning" onclick="btc_post_trade_message('<?php echo $row['id']; ?>');"><?php echo $lang['btn_send_message']; ?></button> 
							<button type="button" class="btn btn-success" id="uploadBtn">Upload file</button>
						</form>
						<hr/>
						<div id="trade_chat_<?php echo $row['id']; ?>">
							<?php 
							$getQuery = $db->query("SELECT * FROM btc_trades_messages WHERE trade_id='$row[id]' ORDER BY id DESC");
							if($getQuery->num_rows>0) {
								while($get = $getQuery->fetch_assoc()) {
									if($_SESSION['btc_uid'] !== $get['uid']) {
										$update = $db->query("UPDATE btc_trades_messages SET readed='1' WHERE id='$get[id]'");
									}
									if($get['attachment'] == "1") {
									$filename = basename($get['message']);
									?>
									<div style="font-size:14px;">
										<b><a href="<?php echo $settings[url]; ?>user/<?php echo idinfo($get['uid'],"username"); ?>"><?php echo idinfo($get['uid'],"username"); ?></a></b> attach file<br/>
										<i class="fa fa-file-o"></i> <a href="<?php echo $settings[url].$get[message]; ?>" target="_blank"><?php echo $filename; ?></a><br/>
										<span class="text text-muted" style="font-size:11px;"><?php echo timeago($get['time']); ?></span>
									</div>
									<hr/>
									<?php
									} else {
									?>
									<div style="font-size:14px;">
										<b><a href="<?php echo $settings[url]; ?>user/<?php echo idinfo($get['uid'],"username"); ?>"><?php echo idinfo($get['uid'],"username"); ?></a></b>: <?php echo $get['message']; ?><br/>
										<span class="text text-muted" style="font-size:11px;"><?php echo timeago($get['time']); ?></span>
									</div>
									<hr/>
									<?php
									}
								}
							} else {
								echo $lang['no_have_messsages'];
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
					</div>
				</div>
			</div>
		</div>

		<?php
		} elseif($row['trader'] == $_SESSION['btc_uid']) {
		// Trader side when client sell bitcoins
		?>
								<!--header section -->
    	<div class="container-fluid page-title">
			<div class="row blue-banner">
            	<div class="container main-container">
                	<div class="col-lg-12 col-md-12 col-sm-12">
								<span style="color:#fff;font-size:35px;font-weight:bold;"><?php echo $lang['ttrade']; ?> #<?php echo $row['id']; ?> <small><?php echo $lang['from_advertisement']; ?> <a href="<?php echo $adlink; ?>" style="color:#fff;">#<?php echo $row['ad_id']; ?></a>, <?php echo $lang['bitcoin_price']; ?> <?php echo $row['btc_price']; ?> <?php echo adinfo($row['ad_id'],"currency"); ?>/BTC</span><br/>
								<span style="color:#fff;font-size:25px;"><?php echo $lang['trade_amount']; ?>: <b><?php echo $row['amount']; ?> <?php echo adinfo($row['ad_id'],"currency"); ?></b> (<?php echo $row['btc_amount']; ?> BTC)</span>
							</div>
                </div>
            </div> 
        </div> 
  	 <!--header section -->
	 <!-- full width section -->
    	<div class="container-fluid white-bg">
        	<div class="row">
            	<div class="container">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="content">
			<div class="col-md-12">
				<?php
				if(isset($_POST['btc_payment_was_made'])) {
					if($minutes !== "0") {
						$form = '<div class="alert alert-warning" style="font-size:18px;"><form action="" method="POST">
								<p>'.$lang[are_you_sure_made_payment].' <a href="'.$settings[url].'user/'.idinfo($row[uid],"username").'">'.idinfo($row[uid],"username").'</a> '.$lang[with_amount].' '.$row[amount].' '.adinfo($row[ad_id],"currency").'?</p>
								<small>'.$lang[this_action_can_be_undo].'</small>
								<br/><br/>
								<button type="submit" class="btn btn-success" name="btc_pwm_confirmed"><i class="fa fa-check"></i> '.$lang[btn_yes_made_payment].'</button> 
								<a href="" class="btn btn-danger"><i class="fa fa-times"></i> '.$lang[btn_no].'</a>
							</form>
							</div>';
							echo $form;
					}
				}
				
				if(isset($_POST['btc_pwm_confirmed'])) {
				   if($row['status'] !== "2" or $row['status'] < "2") {
					$update = $db->query("UPDATE btc_trades SET status='2' WHERE id='$row[id]'");
					$query = $db->query("SELECT * FROM btc_trades WHERE id='$row[id]'");
					$row = $query->fetch_assoc();
					echo success($lang['success_8']);
				   }
				}
				
				if(isset($_POST['btc_cancel_trade'])) {
					if($row['status']>1 or $row['status'] == "0") {
						echo error($lang['error_47']);
					} else {
					$update = $db->query("UPDATE btc_trades SET status='4' WHERE id='$row[id]'");
					$query = $db->query("SELECT * FROM btc_trades WHERE id='$row[id]'");
					$row = $query->fetch_assoc();
					echo info($lang['info_2']);
					}
				}
				?>
			</div>
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-body">
						<b><?php echo $lang['status']; ?>:</b> <span id="trade_status_<?php echo $row['id']; ?>"><?php echo $status; ?></span>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-body">
						<p style="font-size:16px;">
						<?php
						$lang_trade_info_6 = str_ireplace("%amount%",$row['amount'],$lang['trade_info_6']);
						$lang_trade_info_6 = str_ireplace("%currency%",adinfo($row['ad_id'],"currency"),$lang_trade_info_6);
						$lang_trade_info_6 = str_ireplace("%payment_method%",adinfo($row['ad_id'],"payment_method"),$lang_trade_info_6);
						echo $lang_trade_info_6;
						?></p>
						<div class="alert alert-info">
							<b style="font-size:14px;"><?php echo $lang['payment_instructions']; ?></b><br/>
							<?php echo nl2br($row['payment_instructions']); ?>
						</div>
						<p style="font-size:14px;" class="text text-danger"><?php echo $lang['trade_info_7']; ?></p>
						<p><?php echo $lang['trade_info_3']; ?>:</p>
						<br>
						<form action="" method="POST">
							<?php if($row['status'] < 3) { ?>
							<?php if($row['released_bitcoins'] == "0") { ?>
							<?php if($row['status'] < 2) { ?>
							<?php if($minutes !== "0") { ?>
							<button type="submit" class="btn btn-success" name="btc_payment_was_made"><i class="fa fa-check"></i> <?php echo $lang['btn_payment_was_made']; ?></button>
							<button type="submit" class="btn btn-danger" name="btc_cancel_trade" id="btc_cancel_trade"><i class="fa fa-times"></i> <?php echo $lang['btn_cancel_trade']; ?></button>
							<?php } ?>
							<?php } ?>
							<?php } ?>
							<?php } ?>
							<a href="<?php echo $settings['url']; ?>report/trade/<?php echo $row['id']; ?>" class="btn btn-warning"><i class="fa fa-flag"></i> <?php echo $lang['btn_report_trade']; ?></a>
							<?php if($row['status'] == "7") { ?>
								<?php
								$check_feedback = $db->query("SELECT * FROM btc_users_ratings WHERE trade_id='$row[id]' and author='$_SESSION[btc_uid]'");
								if($check_feedback->num_rows==0) {
									?>
									<a href="<?php echo $settings['url']; ?>leave-feedback/trade/<?php echo $row['id']; ?>" class="btn btn-info"><i class="fa fa-comment"></i> <?php echo $lang['btn_leave_feedback']; ?></a>
									<?php
								}
								?>
							<?php } ?>
						</form>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-body">
						<?php
						if($minutes == 0) {
						?>
						<?php echo $lang['trade_info_4']; ?>
						<?php
						} else {
						?>
						<?php
						$lang_trade_info_8 = str_ireplace("%minutes%",$minutes,$lang['trade_info_8']);
						echo $lang_trade_info_8;
						?>
						<?php 
						}
						?>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<script type="text/javascript">
							$(function(){
								var btn = document.getElementById('uploadBtn');
								var trade_id = '<?php echo $row['id']; ?>';
								var uploader = new ss.SimpleUpload({
									button: btn,
									url: '<?php echo $settings['url']; ?>upload.php?trade_id=<?php echo $row['id']; ?>',
									name: 'uploadFile',
									onComplete: function( filename, response ) {
										btc_check_new_file_messages('<?php echo $_SESSION['btc_uid']; ?>','<?php echo $row['id']; ?>');
									  },
									   onError: function() {
										btc_check_new_file_messages('<?php echo $_SESSION['btc_uid']; ?>','<?php echo $row['id']; ?>');
									  }
								});
							});
							
							function btc_int_cnm() {
								btc_check_new_messages('<?php echo $_SESSION['btc_uid']; ?>','<?php echo $row['id']; ?>');
								btc_check_trade_status('<?php echo $row['id']; ?>');
							}
							
							setInterval(btc_int_cnm,3000);
						</script>
						<h3><?php echo $lang['chat']; ?></h3>
						<form id="trade_chat_form_<?php echo $row['id']; ?>">
							<div class="form-group">
								<textarea class="form-control" name="message" rows="3" placeholder="<?php echo $lang['write_message_to_seller']; ?>"></textarea>
							</div>
							<button type="button" class="btn btn-warning" onclick="btc_post_trade_message('<?php echo $row['id']; ?>');"><?php echo $lang['btn_send_message']; ?></button>
							<button type="button" class="btn btn-success" id="uploadBtn">Upload file</button>
						</form>
						<hr/>
						<div id="trade_chat_<?php echo $row['id']; ?>">
							<?php 
							$getQuery = $db->query("SELECT * FROM btc_trades_messages WHERE trade_id='$row[id]' ORDER BY id DESC");
							if($getQuery->num_rows>0) {
								while($get = $getQuery->fetch_assoc()) {
									if($_SESSION['btc_uid'] !== $get['uid']) {
										$update = $db->query("UPDATE btc_trades_messages SET readed='1' WHERE id='$get[id]'");
									}
									if($get['attachment'] == "1") {
									$filename = basename($get['message']);
									?>
									<div style="font-size:14px;">
										<b><a href="<?php echo $settings[url]; ?>user/<?php echo idinfo($get['uid'],"username"); ?>"><?php echo idinfo($get['uid'],"username"); ?></a></b> attach file<br/>
										<i class="fa fa-file-o"></i> <a href="<?php echo $settings[url].$get[message]; ?>" target="_blank"><?php echo $filename; ?></a><br/>
										<span class="text text-muted" style="font-size:11px;"><?php echo timeago($get['time']); ?></span>
									</div>
									<hr/>
									<?php
									} else {
									?>
									<div style="font-size:14px;">
										<b><a href="<?php echo $settings[url]; ?>user/<?php echo idinfo($get['uid'],"username"); ?>"><?php echo idinfo($get['uid'],"username"); ?></a></b>: <?php echo $get['message']; ?><br/>
										<span class="text text-muted" style="font-size:11px;"><?php echo timeago($get['time']); ?></span>
									</div>
									<hr/>
									<?php
									}
								}
							} else {
								echo $lang['no_have_messages'];
							}
							?>
						</div>
					</div>
				</div>
			</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		} else {}
	} elseif($row['type'] == "buy") {
		if($row['uid'] == $_SESSION['btc_uid']) {
		?>
		<!--header section -->
    	<div class="container-fluid page-title">
			<div class="row blue-banner">
            	<div class="container main-container">
                	<div class="col-lg-12 col-md-12 col-sm-12">
								<span style="color:#fff;font-size:35px;font-weight:bold;"><?php echo $lang['ttrade']; ?> #<?php echo $row['id']; ?> <small><?php echo $lang['from_advertisement']; ?> <a href="<?php echo $adlink; ?>" style="color:#fff;">#<?php echo $row['ad_id']; ?></a>, <?php echo $lang['bitcoin_price']; ?> <?php echo $row['btc_price']; ?> <?php echo adinfo($row['ad_id'],"currency"); ?>/BTC</span><br/>
								<span style="color:#fff;font-size:25px;"><?php echo $lang['trade_amount']; ?>: <b><?php echo $row['amount']; ?> <?php echo adinfo($row['ad_id'],"currency"); ?></b> (<?php echo $row['btc_amount']; ?> BTC)</span>
							</div>
                </div>
            </div> 
        </div> 
  	 <!--header section -->
	 <!-- full width section -->
    	<div class="container-fluid white-bg">
        	<div class="row">
            	<div class="container">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="content">
			<div class="col-md-12">
				<?php
				if(isset($_POST['btc_payment_was_made'])) {
					if($minutes !== "0") {
						$form = '<div class="alert alert-warning" style="font-size:18px;"><form action="" method="POST">
								<p>'.$lang[are_you_sure_made_payment_2].' <a href="'.$settings[url].'user/'.idinfo($row[trader],"username").'">'.idinfo($row[trader],"username").'</a> '.$lang[with_amount].' '.$row[amount].' '.adinfo($row[ad_id],"currency").'?</p>
								<small>'.$lang[this_action_can_be_undo].'</small>
								<br/><br/>
								<button type="submit" class="btn btn-success" name="btc_pwm_confirmed"><i class="fa fa-check"></i> '.$lang[btn_yes_made_payment].'</button> 
								<a href="" class="btn btn-danger"><i class="fa fa-times"></i> '.$lang[btn_no].'</a>
							</form>
							</div>';
							echo $form;
					}
				}
				
				if(isset($_POST['btc_pwm_confirmed'])) {
				   if($row['status'] !== "2" or $row['status'] < "2") {
					$update = $db->query("UPDATE btc_trades SET status='2' WHERE id='$row[id]'");
					$query = $db->query("SELECT * FROM btc_trades WHERE id='$row[id]'");
					$row = $query->fetch_assoc();
					echo success($lang['success_9']);
				   }
				}
				
				
				if(isset($_POST['btc_cancel_trade'])) {
					if($row['status']>1 or $row['status'] == "0") {
						echo error($lang['error_47']);
					} else {
					$update = $db->query("UPDATE btc_trades SET status='4' WHERE id='$row[id]'");
					$query = $db->query("SELECT * FROM btc_trades WHERE id='$row[id]'");
					$row = $query->fetch_assoc();
					echo info($lang['info_2']);
					}
				}
				?>
			</div>
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-body">
						<b><?php echo $lang['status']; ?>:</b> <span id="trade_status_<?php echo $row['id']; ?>"><?php echo $status; ?></span>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-body">
						<p style="font-size:16px;">
						<?php
						$lang_trade_info_9 = str_ireplace("%amount%",$row['amount'],$lang['trade_info_9']);
						$lang_trade_info_9 = str_ireplace("%currency%",adinfo($row['ad_id'],"currency"),$lang_trade_info_9);
						$lang_trade_info_9 = str_ireplace("%payment_method%",adinfo($row['ad_id'],"payment_method"),$lang_trade_info_9);
						echo $lang_trade_info_9;
						?></p>
						<div class="alert alert-info">
							<b style="font-size:14px;"><?php echo $lang['payment_instructions']; ?></b><br/>
							<?php echo nl2br($row['payment_instructions']); ?><br/>
							<?php
							$lang_trade_info_10 = str_ireplace("%payment_hash%",$row['payment_hash'],$lang['trade_info_10']);
							echo $lang_trade_info_10;
							?>
						</div>
						<p style="font-size:14px;" class="text text-danger"><?php echo $lang['trade_info_11']; ?></p>
						<p><?php echo $lang['trade_info_3']; ?>:</p>
						<br>
						<form action="" method="POST">
							<?php if($row['status'] < 3) { ?>
							<?php if($row['released_bitcoins'] == "0") { ?>
							<?php if($row['status'] < 2) { ?>
							<?php if($minutes !== "0") { ?>
							<button type="submit" class="btn btn-success" name="btc_payment_was_made"><i class="fa fa-check"></i> <?php echo $lang['btn_payment_was_made']; ?></button>
							<button type="submit" class="btn btn-danger" name="btc_cancel_trade" id="btc_cancel_trade"><i class="fa fa-times"></i> <?php echo $lang['btn_cancel_trade']; ?></button>
							<?php } ?>
							<?php } ?>
							<?php } ?>
							<?php } ?>
							<a href="<?php echo $settings['url']; ?>report/trade/<?php echo $row['id']; ?>" class="btn btn-warning"><i class="fa fa-flag"></i> <?php echo $lang['btn_report_trade']; ?></a>
							<?php if($row['status'] == "7") { ?>
								<?php
								$check_feedback = $db->query("SELECT * FROM btc_users_ratings WHERE trade_id='$row[id]' and author='$_SESSION[btc_uid]'");
								if($check_feedback->num_rows==0) {
									?>
									<a href="<?php echo $settings['url']; ?>leave-feedback/trade/<?php echo $row['id']; ?>" class="btn btn-info"><i class="fa fa-comment"></i> <?php echo $lang['btn_leave_feedback']; ?></a>
									<?php
								}
								?>
							<?php } ?>
						</form>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-body">
						<?php
						if($minutes == 0) {
						?>
						<?php echo $lang['trade_info_4']; ?>
						<?php
						} else {
						?>
						<?php
						$lang_trade_info_5 = str_ireplace("%minutes%",$minutes,$lang['trade_info_5']);
						echo $lang_trade_info_5;
						?><?php 
						}
						?>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<script type="text/javascript">
							
							$(function(){
								var btn = document.getElementById('uploadBtn');
								var trade_id = '<?php echo $row['id']; ?>';
								var uploader = new ss.SimpleUpload({
									button: btn,
									url: '<?php echo $settings['url']; ?>upload.php?trade_id=<?php echo $row['id']; ?>',
									name: 'uploadFile',
									onComplete: function( filename, response ) {
										btc_check_new_file_messages('<?php echo $_SESSION['btc_uid']; ?>','<?php echo $row['id']; ?>');
									  },
									   onError: function() {
										btc_check_new_file_messages('<?php echo $_SESSION['btc_uid']; ?>','<?php echo $row['id']; ?>');
									  }
								});
							});
							
							function btc_int_cnm() {
								btc_check_new_messages('<?php echo $_SESSION['btc_uid']; ?>','<?php echo $row['id']; ?>');
								btc_check_trade_status('<?php echo $row['id']; ?>');
							}
							
							setInterval(btc_int_cnm,3000);
						</script>
						<h3><?php echo $lang['chat']; ?></h3>
						<form id="trade_chat_form_<?php echo $row['id']; ?>">
							<div class="form-group">
								<textarea class="form-control" name="message" rows="3" placeholder="<?php echo $lang['write_message_to_trader']; ?>"></textarea>
							</div>
							<button type="button" class="btn btn-warning" onclick="btc_post_trade_message('<?php echo $row['id']; ?>');"><?php echo $lang['btn_send_message']; ?></button>
							<button type="button" class="btn btn-success" id="uploadBtn">Upload file</button>
						</form>
						<hr/>
						<div id="trade_chat_<?php echo $row['id']; ?>">
							<?php 
							$getQuery = $db->query("SELECT * FROM btc_trades_messages WHERE trade_id='$row[id]' ORDER BY id DESC");
							if($getQuery->num_rows>0) {
								while($get = $getQuery->fetch_assoc()) {
									if($_SESSION['btc_uid'] !== $get['uid']) {
										$update = $db->query("UPDATE btc_trades_messages SET readed='1' WHERE id='$get[id]'");
									}
									if($get['attachment'] == "1") {
									$filename = basename($get['message']);
									?>
									<div style="font-size:14px;">
										<b><a href="<?php echo $settings[url]; ?>user/<?php echo idinfo($get['uid'],"username"); ?>"><?php echo idinfo($get['uid'],"username"); ?></a></b> attach file<br/>
										<i class="fa fa-file-o"></i> <a href="<?php echo $settings[url].$get[message]; ?>" target="_blank"><?php echo $filename; ?></a><br/>
										<span class="text text-muted" style="font-size:11px;"><?php echo timeago($get['time']); ?></span>
									</div>
									<hr/>
									<?php
									} else {
									?>
									<div style="font-size:14px;">
										<b><a href="<?php echo $settings[url]; ?>user/<?php echo idinfo($get['uid'],"username"); ?>"><?php echo idinfo($get['uid'],"username"); ?></a></b>: <?php echo $get['message']; ?><br/>
										<span class="text text-muted" style="font-size:11px;"><?php echo timeago($get['time']); ?></span>
									</div>
									<hr/>
									<?php
									}
								}
							} else {
								echo $lang['no_have_messages'];
							}
							?>
						</div>
					</div>
				</div>
			</div>
	</div>
					</div>
				</div>
			</div>
		</div>
		<?php
		} elseif($row['trader'] == $_SESSION['btc_uid']) {
		?>
				<!--header section -->
    	<div class="container-fluid page-title">
			<div class="row blue-banner">
            	<div class="container main-container">
                	<div class="col-lg-12 col-md-12 col-sm-12">
								<span style="color:#fff;font-size:35px;font-weight:bold;"><?php echo $lang['ttrade']; ?> #<?php echo $row['id']; ?> <small><?php echo $lang['from_advertisement']; ?> <a href="<?php echo $adlink; ?>" style="color:#fff;">#<?php echo $row['ad_id']; ?></a>, <?php echo $lang['bitcoin_price']; ?> <?php echo $row['btc_price']; ?> <?php echo adinfo($row['ad_id'],"currency"); ?>/BTC</span><br/>
								<span style="color:#fff;font-size:25px;"><?php echo $lang['trade_amount']; ?>: <b><?php echo $row['amount']; ?> <?php echo adinfo($row['ad_id'],"currency"); ?></b> (<?php echo $row['btc_amount']; ?> BTC)</span>
							</div>
                </div>
            </div> 
        </div> 
  	 <!--header section -->
	 <!-- full width section -->
    	<div class="container-fluid white-bg">
        	<div class="row">
            	<div class="container">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="content">
			<div class="col-md-12">
				<?php
				if(isset($_POST['btc_release_bitcoins'])) {
					if($row['released_bitcoins'] == "0") {
						if($minutes !== "0") {
							$form = '<div class="alert alert-warning" style="font-size:18px;"><form action="" method="POST">
								<p>'.$lang[are_you_sure_release_bitcoins_2].' <a href="'.$settings[url].'user/'.idinfo($row[uid],"username").'">'.idinfo($row[uid],"username").'</a>?</p>
								<small>'.$lang[this_action_can_be_undo].'</small>
								<br/><br/>
								<button type="submit" class="btn btn-success" name="btc_relaese_bitcoins_confirmed"><i class="fa fa-check"></i> '.$lang[btn_yes_release_bitcoins].'</button> 
								<a href="" class="btn btn-danger"><i class="fa fa-times"></i> '.$lang[btn_no].'</a>
							</form>
							</div>';
							echo $form;
						}
					}	
				}
				
				if(isset($_POST['btc_relaese_bitcoins_confirmed'])) {
					if($minutes !== "0") {
						if($row['released_bitcoins'] !== "1") {
						$update = $db->query("UPDATE btc_trades SET status='7',released_bitcoins='1' WHERE id='$row[id]'");
						$uaddress = walletinfo($row['uid'],"address");
						$taddress = walletinfo($row['trader'],"address");
						$lid = walletinfo($_SESSION['btc_uid'],"lid");
						if (strpos($settings['buy_comission'],'%') !== false) { 
							$bamount = $row['btc_amount'];
							$explode = explode("%",$settings['buy_comission']);
							$fee_percent = $explode[0];
							$new_amount = ($bamount * $fee_percent) / 100;
							$new_amount = round($new_amount,8);
							//$fee_amount = $bamount-$new_amount;
							$bamount = $fee_amount;
							$admincomission = $new_amount;
						} else {
							$admincomission = $settings['buy_comission'];
						}
						$license_query = $db->query("SELECT * FROM btc_blockio_licenses WHERE id='$lid' ORDER BY id");
						$license = $license_query->fetch_assoc();
						$apiKey = $license['license'];
						$pin = $license['secret_pin'];
						$version = 2; // the API version
						$block_io = new BlockIo($apiKey, $pin, $version);
						$withdrawal = $block_io->withdraw_from_addresses(array('amounts' => $row[btc_amount], 'from_addresses' => $taddress, 'to_addresses' => $uaddress));
						$withdrawal = $block_io->withdraw_from_addresses(array('amounts' => $admincomission, 'from_addresses' => $taddress, 'to_addresses' => $license[address]));
						echo success($lang['success_7']);
						$query = $db->query("SELECT * FROM btc_trades WHERE id='$row[id]'");
						$row = $query->fetch_assoc();
						}
					}
				}
				
				if(isset($_POST['btc_cancel_trade'])) {
					if($row['status']>1 or $row['status'] == "0") {
						echo error($lang['error_47']);
					} else {
					$update = $db->query("UPDATE btc_trades SET status='5' WHERE id='$row[id]'");
					$query = $db->query("SELECT * FROM btc_trades WHERE id='$row[id]'");
					$row = $query->fetch_assoc();
					echo info($lang['info_2']);
					}
				}
				?>
			</div>
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-body">
						<b><?php echo $lang['status']; ?>:</b> <span id="trade_status_<?php echo $row['id']; ?>"><?php echo $status; ?></span>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-body">
						<p style="font-size:16px;"><?php
						$lang_trade_info_12 = str_ireplace("%payment_method%",adinfo($row['ad_id'],"payment_method"),$lang['trade_info_12']);
						echo $lang_trade_info_12;
						?></p>
						<p style="font-size:15px;"><?php 
						$lang_trade_info_13 = str_ireplace("%payment_hash%",$row['payment_hash'],$lang['trade_info_13']);
						echo $lang_trade_info_13;
						?></p>
						<p style="font-size:14px;" class="text text-danger"><?php echo $lang['trade_info_14']; ?></p>
						<p><?php echo $lang['trade_info_3']; ?>:</p>
						<br>
						<form action="" method="POST">
							<?php if($row['status'] < 3) { ?>
							<?php if($row['released_bitcoins'] == "0") { ?>
							<?php if($minutes !== "0") { ?>
							<button type="submit" class="btn btn-success" name="btc_release_bitcoins"><i class="fa fa-check"></i> <?php echo $lang['btn_release_bitcoins']; ?></button>
							<button type="submit" class="btn btn-danger" name="btc_cancel_trade" id="btc_cancel_trade"><i class="fa fa-times"></i> <?php echo $lang['btn_cancel_trade']; ?></button>
							<?php } ?>
							<?php } ?>
							<?php } ?>
							<a href="<?php echo $settings['url']; ?>report/trade/<?php echo $row['id']; ?>" class="btn btn-warning"><i class="fa fa-flag"></i> <?php echo $lang['btn_report_trade']; ?></a>
							<?php if($row['status'] == "7") { ?>
								<?php
								$check_feedback = $db->query("SELECT * FROM btc_users_ratings WHERE trade_id='$row[id]' and author='$_SESSION[btc_uid]'");
								if($check_feedback->num_rows==0) {
									?>
									<a href="<?php echo $settings['url']; ?>leave-feedback/trade/<?php echo $row['id']; ?>" class="btn btn-info"><i class="fa fa-comment"></i> <?php echo $lang['btn_leave_feedback']; ?></a>
									<?php
								}
								?>
							<?php } ?>
						</form>
					</div>
				</div>
				
				<div class="panel panel-default">
					<div class="panel-body">
						<?php
						if($minutes == 0) {
						?>
						<?php echo $lang['trade_info_4']; ?>
						<?php
						} else {
						?>
						<?php
						$lang_trade_info_8 = str_ireplace("%minutes%",$minutes,$lang['trade_info_8']);
						echo $lang_trade_info_8;
						?><?php 
						}
						?>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<script type="text/javascript">
							$(function(){
								var btn = document.getElementById('uploadBtn');
								var trade_id = '<?php echo $row['id']; ?>';
								var uploader = new ss.SimpleUpload({
									button: btn,
									url: '<?php echo $settings['url']; ?>upload.php?trade_id=<?php echo $row['id']; ?>',
									name: 'uploadFile',
									onComplete: function( filename, response ) {
										btc_check_new_file_messages('<?php echo $_SESSION['btc_uid']; ?>','<?php echo $row['id']; ?>');
									  },
									   onError: function() {
										btc_check_new_file_messages('<?php echo $_SESSION['btc_uid']; ?>','<?php echo $row['id']; ?>');
									  }
								});
							});
							
							function btc_int_cnm() {
								btc_check_new_messages('<?php echo $_SESSION['btc_uid']; ?>','<?php echo $row['id']; ?>');
								btc_check_trade_status('<?php echo $row['id']; ?>');
							}
							
							setInterval(btc_int_cnm,3000);
						</script>
						<h3><?php echo $lang['chat']; ?></h3>
						<form id="trade_chat_form_<?php echo $row['id']; ?>">
							<div class="form-group">
								<textarea class="form-control" name="message" rows="3" placeholder="Write message to trader."></textarea>
							</div>
							<button type="button" class="btn btn-warning" onclick="btc_post_trade_message('<?php echo $row['id']; ?>');"><?php echo $lang['btn_send_message']; ?></button>
							<button type="button" class="btn btn-success" id="uploadBtn">Upload file</button>
						</form>
						<hr/>
						<div id="trade_chat_<?php echo $row['id']; ?>">
							<?php 
							$getQuery = $db->query("SELECT * FROM btc_trades_messages WHERE trade_id='$row[id]' ORDER BY id DESC");
							if($getQuery->num_rows>0) {
								while($get = $getQuery->fetch_assoc()) {
									if($_SESSION['btc_uid'] !== $get['uid']) {
										$update = $db->query("UPDATE btc_trades_messages SET readed='1' WHERE id='$get[id]'");
									}
									if($get['attachment'] == "1") {
									$filename = basename($get['message']);
									?>
									<div style="font-size:14px;">
										<b><a href="<?php echo $settings[url]; ?>user/<?php echo idinfo($get['uid'],"username"); ?>"><?php echo idinfo($get['uid'],"username"); ?></a></b> attach file<br/>
										<i class="fa fa-file-o"></i> <a href="<?php echo $settings[url].$get[message]; ?>" target="_blank"><?php echo $filename; ?></a><br/>
										<span class="text text-muted" style="font-size:11px;"><?php echo timeago($get['time']); ?></span>
									</div>
									<hr/>
									<?php
									} else {
									?>
									<div style="font-size:14px;">
										<b><a href="<?php echo $settings[url]; ?>user/<?php echo idinfo($get['uid'],"username"); ?>"><?php echo idinfo($get['uid'],"username"); ?></a></b>: <?php echo $get['message']; ?><br/>
										<span class="text text-muted" style="font-size:11px;"><?php echo timeago($get['time']); ?></span>
									</div>
									<hr/>
									<?php
									}
								}
							} else {
								echo $lang['no_have_messages'];
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
					</div>
				</div>
			</div>
		</div>

		<?php
		} else { }
	} else { }
} else { }
?>