<?php
$id = protect($_GET['id']);
$query = $db->query("SELECT * FROM btc_ads WHERE id='$id'");
if($query->num_rows==0) { header("Location: $settings[url]"); }
$row = $query->fetch_assoc();
if($row['type'] == "buy") {
?>
			<!--header section -->
    	<div class="container-fluid page-title">
			<div class="row blue-banner">
            	<div class="container main-container">
					<div class="row">
						<div class="col-md-12">
							<span style="color:#fff;font-size:35px;font-weight:bold;"><?php echo $lang['advertisement']; ?> #<?php echo $row['id']; ?></span><br/>
							<span style="color:#fff;font-size:25px;"><?php echo $lang['sell_bitcoins_to']; ?> <?php echo $row['payment_method']; ?> <?php echo $lang['for']; ?> <?php echo convertBTCprice($row['price'],$row['currency']); ?> <?php echo $row['currency']; ?>/BTC</span>
						</div>
					</div>
                </div>
            </div> 
        </div> 
  	 <!--header section -->
	 
<div class="container-fluid white-bg">
        	<div class="row">
            	<div class="container">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="content">
						<div class="row">
	<div class="col-md-12">
		<?php
		if(checkSession()) {
			if(isset($_POST['btc_sell_bitcoins'])) {
				$amount = protect($_POST['amount']);
				$btc_amount = protect($_POST['btc_amount']);
				$btc_price = protect($_POST['btc_price']);
				$ad_id = $row['id'];
				$trader = $row['uid'];
				$userbalance = get_user_balance($_SESSION['btc_uid']);
				$traderbalance = get_user_balance($row['uid']);
				if (strpos($settings['sell_comission'],'%') !== false) { 
					$bamount = $btc_amount;
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
				$amountwithfees = $btc_amount + 0.0008 + $admincomission;
				$userbalance2 = $userbalance - 0.0008 - $admincomission - 0.0001;
				if($userbalance2 < 0) { $userbalance2 = 0; }
				$payment_instructions = protect($_POST['payment_instructions']);
				if(empty($amount) or empty($btc_amount)) { echo error($lang['error_1']); }
				elseif(empty($payment_instructions)) { echo error($lang['error_2']); }
				elseif($row['min_amount'] > $amount) { $lang_error_3 = str_ireplace("%min_amount%",$row['min_amount'],$lang['error_3']); $lang_error_3 = str_ireplace("%currency%",$row['currency'],$lang_error_3); echo error($lang_error_3); }
				elseif($row['max_amount'] < $amount) { $lang_error_4 = str_ireplace("%max_amount%",$row['max_amount'],$lang['error_4']); $lang_error_4 = str_ireplace("%currency%",$row['currency'],$lang_error_4); echo error($lang_error_4); }
				//elseif($traderbalance < $btc_amount) { echo error("Trader not have enough bitcoins in stock."); }
				elseif($userbalance < $amountwithfees) { $lang_error_5 = str_ireplace("%userbalance%",$userbalance2,$lang['error_5']); echo error($lang_error_5); }
				elseif($row['require_document'] == "1" && idinfo($_SESSION['btc_uid'],"document_verified") !== "1") { echo error("$lang[ad_require_doc_verify] $lang[please_go_to_tab] <a href='$settings[url]account/verification'>$lang[menu_verification]</a>."); }
				elseif($row['require_email'] == "1" && idinfo($_SESSION['btc_uid'],"email_verified") !== "1") { echo error("$lang[ad_require_email_verify] $lang[please_go_to_tab] <a href='$settings[url]account/verification'>$lang[menu_verification]</a>."); }
				elseif($row['require_mobile'] == "1" && idinfo($_SESSION['btc_uid'],"mobile_verified") !== "1") { echo error("$lang[ad_require_mobile_verify] $lang[please_go_to_tab] <a href='$settings[url]account/verification'>$lang[menu_verification]</a>."); }
				else {
					$timeout = $row['process_time'] * 60;
					$timeout = time() + $timeout;
					$time = time();
					$insert = $db->query("INSERT btc_trades (uid,type,ad_id,trader,payment_hash,btc_price,btc_amount,amount,payment_instructions,status,created,timeout) VALUES ('$_SESSION[btc_uid]','sell','$ad_id','$trader','$payment_hash','$btc_price','$btc_amount','$amount','$payment_instructions','1','$time','$timeout')"); 
					$getlast = $db->query("SELECT * FROM btc_trades WHERE uid='$_SESSION[btc_uid]' ORDER BY id DESC LIMIT 1");
					$get = $getlast->fetch_assoc();
					$insert = $db->query("INSERT btc_users_notifications (uid,notified,trade_id,time) VALUES ('$trader','0','$get[id]','$time')");
					$pm = str_ireplace(" ","-",$row['payment_method']);
					$redirect = $settings['url']."trade/Bitcoin-to-".$pm."/".$get['id'];
					header("Location: $redirect");
				}
			}
		}
		?>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-body">
				<h3><?php echo $lang['trader']; ?> <a href="<?php echo $settings['url']; ?>user/<?php echo idinfo($row['uid'],"username"); ?>" id="user_status" data-toggle="tooltip" data-placement="top" title="<?php echo activity_time($row['uid']); ?>"><?php echo idinfo($row['uid'],"username"); ?></a></h3>
				<p>
				<table class="table">
					<tbody>
					<tr>
				<?php
					$positive = $db->query("SELECT * FROM btc_users_ratings WHERE uid='$row[uid]' and type='1'");
					$neutral = $db->query("SELECT * FROM btc_users_ratings WHERE uid='$row[uid]' and type='2'");
					$negative = $db->query("SELECT * FROM btc_users_ratings WHERE uid='$row[uid]' and type='3'");
					?>
				<td>	<span class="text text-success"><i class="fa fa-smile-o"></i> <?php echo $positive->num_rows; ?> <?php echo $lang['positive_feedbacks']; ?></span></td>
					<td><span class="text text-warning"><i class="fa fa-meh-o"></i> <?php echo $neutral->num_rows; ?> <?php echo $lang['neutral_feedbacks']; ?></span></td>
					<td><span class="text text-danger"><i class="fa fa-frown-o"></i> <?php echo $negative->num_rows; ?> <?php echo $lang['negative_feedbacks']; ?></span></td>
				</tr>
				</tbody>
				</table>
				<?php 
				if(is_online($row['uid']) == "0") {
					$act = activity_time($row['uid']);
					$lang_info_1 = str_ireplace("%act%",$act,$lang['info_1']);
					$lang_info_1 = str_ireplace("%process_time%",$row['process_time'],$lang_info_1);
					echo info($lang_info_1);
				}
				?>
			</div>
		</div>
		
		<div class="panel panel-default panel-blue">
			<div class="panel-body">
				<h3><?php echo $lang['sell_your_bitcoins']; ?></h3>
				<br>
				<form action="" method="POST">
				<div class="row">
					<div class="col-md-5">
						<div class="input-group">
						  <input type="text" class="form-control input-lg" placeholder="0.0000" name="btc_amount" id="btc_amount" onkeyup="calculate_amount(this.value);" onkeydown="calculate_amount(this.value);">
						  <span class="input-group-addon" id="basic-addon2">BTC</span>
						</div>
					</div>
					<div class="col-md-2 text-center"><i class="fa fa-refresh fa-3x"></i></div>
					<div class="col-md-5">
						<div class="input-group">
						  <input type="text" class="form-control input-lg" placeholder="0.00" name="amount" id="amount" onkeyup="calculate_btc_amount(this.value);" onkeydown="calculate_btc_amount(this.value);">
						  <span class="input-group-addon" id="basic-addon2"><?php echo $row['currency']; ?></span>
						</div>
					</div>
					<div class="col-md-12">
						<br>
						<textarea class="form-control" rows="3" name="payment_instructions" placeholder="<?php $lang_textarea = str_ireplace("%payment_method%",$row['payment_method'],$lang['sell_bitcoins_textarea']); echo $lang_textarea; ?>"></textarea>
					</div>
					<input type="hidden" name="type" value="sell">
					<input type="hidden" name="ad_id" value="<?php echo $row['id']; ?>">
					<input type="hidden" name="trader" value="<?php echo $row['id']; ?>">
					<input type="hidden" name="btc_price" value="<?php echo convertBTCprice($row['price'],$row['currency']); ?>" id="btc_price">
					<div class="col-md-12">
						<br>
						<center>
						<?php if(checkSession()) { if($_SESSION['btc_uid'] == $row['uid']) { ?>
						<?php echo $lang['this_ad_is_yours']; ?>
						<?php } else { ?>
						<button type="submit" class="btn btn-warning btn-lg" name="btc_sell_bitcoins"><i class="fa fa-bitcoin"></i> <?php echo $lang['btn_sell']; ?></button>
						<?php } } else { ?>
						<?php echo $lang['login_is_required']; ?>
						<?php } ?>
						</center>
					</div>	
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<?php if($row['require_document'] == "1" or $row['require_email'] == "1" or $row['require_mobile'] == "1") { ?>
		<div class="panel panel-default">
			<div class="panel-body">
				<h3><?php echo $lang['this_ad_require']; ?></h3>
				<?php if($row['require_document'] == "1") { ?><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['verified_documents']; ?></span><br/><?php } ?>
				<?php if($row['require_email'] == "1") { ?><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['verified_email_address']; ?></span><br/><?php } ?>
				<?php if($row['require_mobile'] == "1") { ?><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['verified_mobile']; ?></span><br/><?php } ?>
				<br/>
			</div>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-body">
				<h3><?php echo $lang['terms_of_trade']; ?></h3>
				<?php echo nl2br($row['terms']); ?>
			</div>
		</div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
					</div>
<?php } elseif($row['type'] == "sell") { ?>
			<!--header section -->
    	<div class="container-fluid page-title">
			<div class="row blue-banner">
            	<div class="container main-container">
					<div class="row">
						<div class="col-md-12">
							<span style="color:#fff;font-size:35px;font-weight:bold;"><?php echo $lang['advertisement']; ?> #<?php echo $row['id']; ?></span><br/>
						<span style="color:#fff;font-size:25px;"><?php echo $lang['buy_bitcoins_via']; ?> <?php echo $row['payment_method']; ?> <?php echo $lang['for']; ?> <?php echo convertBTCprice($row['price'],$row['currency']); ?> <?php echo $row['currency']; ?>/BTC</span>
					</div>
					</div>
                </div>
            </div> 
        </div> 
  	 <!--header section -->
	 
<div class="container-fluid white-bg">
        	<div class="row">
            	<div class="container">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="content">
						<div class="row">
	<div class="col-md-12">
		<?php
		if(checkSession()) {
			if(isset($_POST['btc_buy_bitcoins'])) {
				$amount = protect($_POST['amount']);
				$btc_amount = protect($_POST['btc_amount']);
				$btc_price = protect($_POST['btc_price']);
				$ad_id = $row['id'];
				$trader = $row['uid'];
				$userbalance = get_user_balance($_SESSION['btc_uid']);
				$traderbalance = get_user_balance($row['uid']);
				if (strpos($settings['buy_comission'],'%') !== false) { 
					$bamount = $btc_amount;
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
				$maxb = $traderbalance - 0.0008 - $admincomission - 0.0001;
				$maxa = $maxb * $btc_price;
				$maxa = number_format($maxa,2);
				$hash = randomHash(10);
				$payment_hash = strtoupper($hash);
				if($maxa < 0) { $maxa = 0; }
				$amountwithfees = $btc_amount + 0.0008 + $admincomission + 0.0001;
				$userbalance2 = $userbalance - 0.0008 - $admincomission - 0.0001;
				if($userbalance2 < 0) { $userbalance2 = 0; }
				$payment_instructions = $row['payment_instructions'];
				if(empty($amount) or empty($btc_amount)) { echo error($lang['error_1']); }
				elseif($row['min_amount'] > $amount) { $lang_error_3 = str_ireplace("%min_amount%",$row['min_amount'],$lang['error_3']); $lang_error_3 = str_ireplace("%currency%",$row['currency'],$lang_error_3); echo error($lang_error_3); }
				elseif($row['max_amount'] < $amount) { $lang_error_4 = str_ireplace("%max_amount%",$row['max_amount'],$lang['error_4']); $lang_error_4 = str_ireplace("%currency%",$row['currency'],$lang_error_4); echo error($lang_error_4); }
				elseif($traderbalance < $amountwithfees) { $lang_error_6 = str_ireplace("%amount%",$maxa,$lang['error_6']); $lang_error_6 = str_ireplace("%currency%",$row['currency'],$lang_error_6); echo error($lang_error_6); }
				elseif($row['require_document'] == "1" && idinfo($_SESSION['btc_uid'],"document_verified") !== "1") { echo error("$lang[ad_require_doc_verify] $lang[please_go_to_tab] <a href='$settings[url]account/verification'>$lang[menu_verification]</a>."); }
				elseif($row['require_email'] == "1" && idinfo($_SESSION['btc_uid'],"email_verified") !== "1") { echo error("$lang[ad_require_email_verify] $lang[please_go_to_tab] <a href='$settings[url]account/verification'>$lang[menu_verification]</a>."); }
				elseif($row['require_mobile'] == "1" && idinfo($_SESSION['btc_uid'],"mobile_verified") !== "1") { echo error("$lang[ad_require_mobile_verify] $lang[please_go_to_tab] <a href='$settings[url]account/verification'>$lang[menu_verification]</a>."); }
				else {
					$timeout = $row['process_time'] * 60;
					$timeout = time() + $timeout;
					$time = time();
					$insert = $db->query("INSERT btc_trades (uid,type,ad_id,trader,payment_hash,btc_price,btc_amount,amount,payment_instructions,status,created,timeout) VALUES ('$_SESSION[btc_uid]','buy','$ad_id','$trader','$payment_hash','$btc_price','$btc_amount','$amount','$payment_instructions','1','$time','$timeout')"); 
					$getlast = $db->query("SELECT * FROM btc_trades WHERE uid='$_SESSION[btc_uid]' ORDER BY id DESC LIMIT 1");
					$get = $getlast->fetch_assoc();
					$insert = $db->query("INSERT btc_users_notifications (uid,notified,trade_id,time) VALUES ('$trader','0','$get[id]','$time')");
					$pm = str_ireplace(" ","-",$row['payment_method']);
					$redirect = $settings['url']."trade/".$pm."-to-Bitcoin/".$get['id'];
					header("Location: $redirect");
				}
			}
		}
		?>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-body">
				<h3><?php echo $lang['trader']; ?> <a href="<?php echo $settings['url']; ?>user/<?php echo idinfo($row['uid'],"username"); ?>" id="user_status" data-toggle="tooltip" data-placement="top" title="<?php echo activity_time($row['uid']); ?>"><?php echo idinfo($row['uid'],"username"); ?></a></h3>
				<p>
				<table class="table">
					<tbody>
					<tr>
				<?php
					$positive = $db->query("SELECT * FROM btc_users_ratings WHERE uid='$row[uid]' and type='1'");
					$neutral = $db->query("SELECT * FROM btc_users_ratings WHERE uid='$row[uid]' and type='2'");
					$negative = $db->query("SELECT * FROM btc_users_ratings WHERE uid='$row[uid]' and type='3'");
					?>
				<td>	<span class="text text-success"><i class="fa fa-smile-o"></i> <?php echo $positive->num_rows; ?> <?php echo $lang['positive_feedbacks']; ?></span></td>
					<td><span class="text text-warning"><i class="fa fa-meh-o"></i> <?php echo $neutral->num_rows; ?> <?php echo $lang['neutral_feedbacks']; ?></span></td>
					<td><span class="text text-danger"><i class="fa fa-frown-o"></i> <?php echo $negative->num_rows; ?> <?php echo $lang['negative_feedbacks']; ?></span></td>
				</tr>
				</tbody>
				</table>
				<?php 
				if(is_online($row['uid']) == "0") {
					$act = activity_time($row['uid']);
					$lang_info_1 = str_ireplace("%act%",$act,$lang['info_1']);
					$lang_info_1 = str_ireplace("%process_time%",$row['process_time'],$lang_info_1);
					echo info($lang_info_1);
				}
				?>
			</div>
		</div>
		
		<div class="panel panel-default panel-blue">
			<div class="panel-body">
				<h3><?php echo $lang['buy_bitcoins']; ?></h3>
				<br>
				<form action="" method="POST">
				<div class="row">
					<div class="col-md-5">
						<div class="input-group">
						  <input type="text" class="form-control input-lg" placeholder="0.00" name="amount" id="amount" onkeyup="calculate_btc_amount(this.value);" onkeydown="calculate_btc_amount(this.value);">
						  <span class="input-group-addon" id="basic-addon2"><?php echo $row['currency']; ?></span>
						</div>
					</div>
					<div class="col-md-2 text-center"><i class="fa fa-refresh fa-3x"></i></div>
					<div class="col-md-5">
						<div class="input-group">
						  <input type="text" class="form-control input-lg" placeholder="0.0000" name="btc_amount" id="btc_amount" onkeyup="calculate_amount(this.value);" onkeydown="calculate_amount(this.value);">
						  <span class="input-group-addon" id="basic-addon2">BTC</span>
						</div>
					</div>
					<input type="hidden" name="type" value="sell">
					<input type="hidden" name="ad_id" value="<?php echo $row['id']; ?>">
					<input type="hidden" name="trader" value="<?php echo $row['id']; ?>">
					<input type="hidden" name="btc_price" value="<?php echo convertBTCprice($row['price'],$row['currency']); ?>" id="btc_price">
					<div class="col-md-12">
						<br>
						<center>
						<?php if(checkSession()) { if($_SESSION['btc_uid'] == $row['uid']) { ?>
						<?php echo $lang['this_ad_is_yours']; ?>
						<?php } else { ?>
						<button type="submit" class="btn btn-warning btn-lg" name="btc_buy_bitcoins"><i class="fa fa-bitcoin"></i> <?php echo $lang['btn_buy']; ?></button>
						<?php } } else { ?>
						<?php echo $lang['login_is_required']; ?>
						<?php } ?>
						</center>
					</div>	
				</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-4">
	<?php if($row['require_document'] == "1" or $row['require_email'] == "1" or $row['require_mobile'] == "1") { ?>
		<div class="panel panel-default">
			<div class="panel-body">
				<h3><?php echo $lang['this_ad_require']; ?></h3>
				<?php if($row['require_document'] == "1") { ?><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['verified_documents']; ?></span><br/><?php } ?>
				<?php if($row['require_email'] == "1") { ?><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['verified_email_address']; ?></span><br/><?php } ?>
				<?php if($row['require_mobile'] == "1") { ?><span class="text text-success"><i class="fa fa-check"></i> <?php echo $lang['verified_mobile']; ?></span><br/><?php } ?>
				<br/>
			</div>
		</div>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-body">
				<h3><?php echo $lang['terms_of_trade']; ?></h3>
				<?php echo nl2br($row['terms']); ?>
			</div>
		</div>
</div>
						</div>
					</div>
				</div>
			</div>
		</div>
					</div>
<?php } else { } ?>