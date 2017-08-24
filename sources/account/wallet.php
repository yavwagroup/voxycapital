<!-- Page Title-->
    	<div class="container-fluid page-title dashboard ">
			<div class="row blue-banner">
            	<div class="container main-container">
                	<div class="col-md-4">
						<span style="color:#fff;font-size:35px;font-weight:bold;"><?php echo $lang['av_balance']; ?></span><br/>
						<span style="color:#fff;font-size:25px;"><i class="fa fa-bitcoin"></i> <?php echo get_user_balance($_SESSION['btc_uid']); ?></span>
					</div>
					<div class="col-md-4">
						<span style="color:#fff;font-size:35px;font-weight:bold;"><?php echo $lang['pe_balance']; ?></span><br/>
						<span style="color:#fff;font-size:25px;"><i class="fa fa-bitcoin"></i> <?php echo walletinfo($_SESSION['btc_uid'],"pending_received_balance"); ?></span>
					</div>
					<div class="col-md-4">
						
					</div>
                </div>
            </div>       
        </div>
    <!-- Page Title-->
	
	<div class="container ex_padding" style="padding-top:20px;padding-bottom:20px;font-size:15px;">
		<div class="row">
			<div class="col-md-12">
				<?php
				if(isset($_POST['btc_send_bitcoins'])) {
					$amount = protect($_POST['amount']);
					$orig_amount = protect($_POST['amount']);
					$recipient = protect($_POST['recipient']);
					$min_amount = $settings['withdrawal_comission']+0.0008;
					$ubalance = get_user_balance($_SESSION['btc_uid']);
					$checkreports = $db->query("SELECT * FROM btc_traders WHERE trader='$_SESSION[btc_uid]' and status='0' or uid='$_SESSION[btc_uid]' and status='0'");
					if(!is_numeric($amount)) { echo error($lang['error_35']); }
					elseif($checkreports->num_rows>0) { echo error($lang['error_46']); }
					elseif($amount > $ubalance) { echo error("You do not have enough funds for withdrawal."); }
					elseif($amount < $min_amount) { $lang_error_36 = str_ireplace("%min_amount%",$min_amount,$lang['error_36']); echo error($lang_error_36); }
					elseif(empty($recipient)) { echo error($lang['error_37']); }
					else {
						$amount = $amount - $settings['withdrawal_comission'] - 0.0004;
						$min_amount1 = $min_amount+0.0001;
						if($ubalance < $min_amount) { $lang_error_38 = str_ireplace("%min_amount%",$min_amount1,$lang['error_38']); echo error($lang_error_38); }
						else {
							$uaddress = walletinfo($_SESSION['btc_uid'],"address");
							$lid = walletinfo($_SESSION['btc_uid'],"lid");
							$license_query = $db->query("SELECT * FROM btc_blockio_licenses WHERE id='$lid' ORDER BY id");
							$license = $license_query->fetch_assoc();
							$apiKey = $license['license'];
							$pin = $license['secret_pin'];
							$version = 2; // the API version
							$block_io = new BlockIo($apiKey, $pin, $version);
							$withdrawal = $block_io->withdraw_from_addresses(array('amounts' => $amount, 'from_addresses' => $uaddress, 'to_addresses' => $recipient));
							$withdrawal = $block_io->withdraw_from_addresses(array('amounts' => $settings[withdrawal_comission], 'from_addresses' => $uaddress, 'to_addresses' => $license[address]));
							$lang_success_14 = str_ireplace("%orig_amount%",$orig_amount,$lang['success_14']);
							$lang_success_14 = str_ireplace("%recipient%",$recipient,$lang_success_14);
							echo success($lang_success_14);
						}
					}
				}
				?>
			</div>
			<div class="col-md-4">
			
				<div class="panel panel-default">
					<div class="panel-body">
						<h4><?php echo $lang['deposit_receive_bitcoins']; ?></h4>
						<p><?php echo $lang['d_r_bitcoins']; ?></p>
						<center>
						<img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=<?php echo walletinfo($_SESSION['btc_uid'],"address"); ?>&choe=UTF-8"><br/>
						<input type="text" class="form-control text-center" value="<?php echo walletinfo($_SESSION['btc_uid'],"address"); ?>"  onclick="this.select();">
						</center>
					</div>
				</div>
				
				<div class="list-group">
				  <a href="<?php echo $settings['url']; ?>account/wallet" class="list-group-item active"><i class="fa fa-bitcoin"></i> <?php echo $lang['menu_wallet']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/transactions" class="list-group-item"><i class="fa fa-exchange"></i> <?php echo $lang['menu_transactions']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/advertisements" class="list-group-item"><i class="fa fa-globe"></i> <?php echo $lang['menu_advertisements']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/trades" class="list-group-item"><i class="fa fa-refresh"></i> <?php echo $lang['menu_trades']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/settings" class="list-group-item"><i class="fa fa-cogs"></i> <?php echo $lang['menu_settings']; ?></a>
				  
				  <a href="<?php echo $settings['url']; ?>account/verification" class="list-group-item"><i class="fa fa-check"></i> <?php echo $lang['menu_verification']; ?></a>
				</div>
				
			</div>
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-body">
						<h4><?php echo $lang['pending_trades']; ?></h4>
						<?php echo $lang['pending_trades_info']; ?>
						<?php
						$query = $db->query("SELECT * FROM btc_trades WHERE uid='$_SESSION[btc_uid]' and status < 3 or trader='$_SESSION[btc_uid]' and status < 3  ORDER BY id");
						if($query->num_rows>0) {
								while($row = $query->fetch_assoc()) {
											if(tradeinfo($row['id'],"type") == "buy") {
												$adid = tradeinfo($row['id'],"ad_id");
												$pm = adinfo($adid,"payment_method");
												$pm = str_ireplace(" ","-",$pm);
												$tradelink = $settings['url']."trade/".$pm."-to-Bitcoin/".$row['id'];
											} else {
												$adid = tradeinfo($row['id'],"ad_id");
												$pm = adinfo($adid,"payment_method");
												$pm = str_ireplace(" ","-",$pm);
												$tradelink = $settings['url']."trade/Bitcoin-to-".$pm."/".$row['id'];
											}
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
										if($row['uid'] == $_SESSION['btc_uid']) { $youclient = '('.$lang[you].')'; } else { $youclient = ''; }
										if($row['trader'] == $_SESSION['btc_uid']) { $youtrader = '('.$lang[you].')'; } else { $youtrader = ''; }
										if($row['type'] == "sell") { $type = $lang['sell']; } else { $type = $lang['buy']; }
										echo '<div class="panel panel-default">
										<div class="panel-body">
										<table class="table table-striped">
										<thead>
											<tr>
												<th>'.$lang[type].'</th>
												<th>'.$lang[client].'</th>
												<th>'.$lant[trader].'</th>
												<th>'.$lang[amount].'</th>
												<th>'.$lang[payment_method].'</th>
											</tr>
										</thead>
										<tbody>
										<tr>
											<td>'.$type.'</td>
											<td><a href="'.$settings[url].'user/'.idinfo($row[uid],"username").'">'.idinfo($row[uid],"username").'</a> '.$youclient.'</td>
											<td><a href="'.$settings[url].'user/'.idinfo($row[trader],"username").'">'.idinfo($row[trader],"username").'</a> '.$youtrader.'</td>
											<td>'.$row[amount].' '.adinfo($row[ad_id],"currency").' ('.$row[btc_amount].' BTC)</td>
											<td>'.adinfo($row[ad_id],"payment_method").'</td>
										</tr>
										</tbody>
										<thead>
											<tr>
												<th colspan="5">
													'.$lang[status].': '.$status.'
												</th>
											</tr>
										</thead>
										</table>
										<a href="'.$tradelink.'" class="btn btn-primary">'.$lang[btn_process_trade].'</a> 
										<a href="'.$settings[url].'cancel/trade/'.$row[id].'" class="btn btn-danger">'.$lang[btn_cancel_trade].'</a>
										</div>
										</div>';
								}
						} else {
							echo info($lang['info_8']);
						}
						?>
					</div>
				</div>
				
				<div class="panel panel-default panel-blue">
					<div class="panel-body">
						<h4><?php echo $lang['send_bitcoins']; ?></h4>
						<form action="" method="POST">
							<div class="form-group">
								<label><?php echo $lang['amount']; ?></label>
								<input type="text" class="form-control" name="amount" placeholder="0.0000000">
							</div>
							<div class="form-group">
								<label><?php echo $lang['recipient']; ?></label>
								<input type="text" class="form-control" name="recipient">
							</div>
							<button type="submit" class="btn btn-warning" name="btc_send_bitcoins"><?php echo $lang['btn_send']; ?></button> 
							<span class="pull-right"><?php echo $lang['minimal_transaction_fee']; ?>: <?php echo $settings['withdrawal_comission']+0.0008; ?> BTC</span>
						</form>
					</div>	
				</div>
				
				<div class="panel panel-default">
					<div class="panel-body">
						<h4><?php echo $lang['latest_transactions']; ?></h4>
						<p><?php echo $lang['latest_transactions_info']; ?></p>
						<?php
						$query = $db->query("SELECT * FROM btc_users_transactions WHERE uid='$_SESSION[btc_uid]' ORDER BY id DESC LIMIT 5");
						if($query->num_rows>0) {
								while($row = $query->fetch_assoc()) {
									?>
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="row">
												<div class="col-md-2 text-center">
													<?php
													if($row['type'] == "sent") {
														echo '<span class="text text-danger text-center"><i class="fa fa-arrow-circle-o-up fa-2x"></i><br/>'.$lang[sent].'</span>';
													} else {
														echo '<span class="text text-success text-center"><i class="fa fa-arrow-circle-o-down fa-2x"></i><br/>'.$lang[received].'</span>';
													}
													?>
													<br><br>
													<span class="text-muted"><small><?php echo $row['confirmations']." $lang[confirmations]"; ?></small></span>
												</div>
												<div class="col-md-10">
													<table class="table table-striped">
														<tbody>
															<tr>
																<td><?php echo $lang['transaction']; ?>:</td>
																<td><a href="https://chain.so/tx/BTC/<?php echo $row['txid']; ?>"><?php $string = $row['txid']; if(strlen($string) > 30) { $string = substr($string, 0, 30).'...'; echo $string; } else { echo $string; } ?></a></td>
															</tr>	
															<tr>
																<td><?php echo $lang['sender']; ?>:</td>
																<td><?php echo $row['sender']; ?></td>
															</tr>
															<tr>
																<td><?php echo $lang['recipient']; ?>:</td>
																<td><?php echo $row['recipient']; ?></td>
															</tr>
															<tr>
																<td><?php echo $lang['amount']; ?>:</td>
																<td><?php echo $row['amount']; ?> BTC</td>
															</tr>
															<tr>
																<td><?php echo $lang['time']; ?>:</td>
																<td><?php echo date("d/m/Y H:i",$row['time']); ?></td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
									<?php
								}
						} else {
							echo info($lang['info_9']);
						}
						?>
					</div>
				</div>
			
			</div>
		</div>
	</div>