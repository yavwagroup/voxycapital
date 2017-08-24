 <!-- Page Title-->
    	<div class="container-fluid blue-banner page-title bg-image">
		 
        </div>
    <!-- Page Title-->
	<div class="container ex_padding" style="padding-top:20px;padding-bottom:20px;font-size:15px;">
		<div class="row">
			<div class="col-md-3">
				
				<div class="list-group">
				  <a href="<?php echo $settings['url']; ?>account/wallet" class="list-group-item"><i class="fa fa-bitcoin"></i> <?php echo $lang['menu_wallet']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/transactions" class="list-group-item"><i class="fa fa-exchange"></i> <?php echo $lang['menu_transactions']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/advertisements" class="list-group-item"><i class="fa fa-globe"></i> <?php echo $lang['menu_advertisements']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/trades" class="list-group-item active"><i class="fa fa-refresh"></i> <?php echo $lang['menu_trades']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/settings" class="list-group-item"><i class="fa fa-cogs"></i> <?php echo $lang['menu_settings']; ?></a>
				  
				  <a href="<?php echo $settings['url']; ?>account/verification" class="list-group-item"><i class="fa fa-check"></i> <?php echo $lang['menu_verification']; ?></a>
				</div>
				
			</div>
			<div class="col-md-9">
			
				<div class="panel panel-default">
					<div class="panel-body">
						<h4><?php echo $lang['menu_trades']; ?></h4>
						<hr/>
						<?php
						$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
						$limit = 10;
						$startpoint = ($page * $limit) - $limit;
						if($page == 1) {
							$i = 1;
						} else {
							$i = $page * $limit;
						}
						$statement = "btc_trades WHERE uid='$_SESSION[btc_uid]' or trader='$_SESSION[btc_uid]'";
						$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
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
												$status =  '<span class="label label-info">'.$lang[status_1_1].'</span>';
											} elseif($row['status'] == "2") {
												$status = '<span class="label label-info">'.$lang[status_2_1].'</span>';
											} elseif($row['status'] == "3") {
												$status = '<span class="label label-info">'.$lang[status_3_1].'</span>';
											} elseif($row['status'] == "4") {
												$status = '<span class="label label-danger">'.$lang[status_4].'</span>';
											} elseif($row['status'] == "5") {
												$status = '<span class="label label-danger">'.$lang[status_5].'</span>';
											} elseif($row['status'] == "6") {
												$status = '<span class="label label-danger">'.$lang[status_6].'</span>';
											} elseif($row['status'] == "7") {
												$status = '<span class="label label-success">'.$lang[status_7].'</span>';
											} else {
												$status = '<span class="label label-default">Unknown</span>';
											}
										} else {
											if($row['status'] == "0") { 
													$status =  '<span class="text text-info">'.$lang[status_0].'</span>';
												} elseif($row['status'] == "1") {
												$status =  '<span class="label label-info">'.$lang[status_1_2].'</span>';
											} elseif($row['status'] == "2") {
												$status = '<span class="label label-info">'.$lang[status_2_2].'</span>';
											} elseif($row['status'] == "3") {
												$status = '<span class="label label-info">'.$lang[status_3_2].'</span>';
											} elseif($row['status'] == "4") {
												$status = '<span class="label label-danger">'.$lang[status_4].'</span>';
											} elseif($row['status'] == "5") {
												$status = '<span class="label label-danger">'.$lang[status_5].'</span>';
											} elseif($row['status'] == "6") {
												$status = '<span class="label label-danger">'.$lang[status_6].'</span>';
											} elseif($row['status'] == "7") {
												$status = '<span class="label label-success">'.$lang[status_7].'</span>';
											} else {
												$status = '<span class="label label-default">Unknown</span>';
											}
										}
										if($row['uid'] == $_SESSION['btc_uid']) { $youclient = '('.$lang[you].')'; } else { $youclient = ''; }
										if($row['trader'] == $_SESSION['btc_uid']) { $youtrader = '('.$lang[you].')'; } else { $youtrader = ''; }
										if($row['type'] == "sell") { $type = $lang['sell']; } else { $type = $lang['buy']; }
										if($row['status'] < 3) {
											$linkz = '<a href="'.$tradelink.'" class="btn btn-primary">'.$lang[btn_process_trade].'</a> 
										<a href="'.$settings[url].'cancel/trade/'.$row[id].'" class="btn btn-danger">'.$lang[btn_cancel_trade].'</a>';
										} else {
											$linkz = '<a href="'.$tradelink.'" class="btn btn-primary">'.$lang[btn_preview_trade].'</a>';
										}
							if($row['status'] == "7") {
								$check_feedback = $db->query("SELECT * FROM btc_users_ratings WHERE trade_id='$row[id]' and author='$_SESSION[btc_uid]'");
								if($check_feedback->num_rows==0) {
									$linkz .= ' <a href="'.$settings[url].'leave-feedback/trade/'.$row[id].'" class="btn btn-info"><i class="fa fa-comment"></i> '.$lang[btn_leave_feedback].'</a>';
								}
							}
										echo '<div class="panel panel-default">
										<div class="panel-body">
										<table class="table table-striped">
										<thead>
											<tr>
												<th>'.$lang[type].'</th>
												<th>'.$lang[client].'</th>
												<th>'.$lang[trader].'</th>
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
										'.$linkz.'
										</div>
										</div>';
								}
						} else {
							echo info($lang['info_6']);
						}
						?>

						<?php
						$ver = $settings['url']."account/trades";
						if(web_pagination($statement,$ver,$limit,$page)) {
							echo web_pagination($statement,$ver,$limit,$page);
						}
						?>
					</div>
				</div>
			
			</div>
		</div>
	</div>