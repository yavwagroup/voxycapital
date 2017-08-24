 <!-- Page Title-->
    	<div class="container-fluid blue-banner page-title bg-image">
		 
        </div>
    <!-- Page Title-->
	<div class="container ex_padding" style="padding-top:20px;padding-bottom:20px;font-size:15px;">
		<div class="row">
			<div class="col-md-3">
				
				<div class="list-group">
				  <a href="<?php echo $settings['url']; ?>account/wallet" class="list-group-item"><i class="fa fa-bitcoin"></i> <?php echo $lang['menu_wallet']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/transactions" class="list-group-item active"><i class="fa fa-exchange"></i> <?php echo $lang['menu_transactions']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/advertisements" class="list-group-item"><i class="fa fa-globe"></i> <?php echo $lang['menu_advertisements']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/trades" class="list-group-item"><i class="fa fa-refresh"></i> <?php echo $lang['menu_trades']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/settings" class="list-group-item"><i class="fa fa-cogs"></i> <?php echo $lang['menu_settings']; ?></a>
				  
				  <a href="<?php echo $settings['url']; ?>account/verification" class="list-group-item"><i class="fa fa-check"></i> <?php echo $lang['menu_verification']; ?></a>
				</div>
				
			</div>
			<div class="col-md-9">
			
				<div class="panel panel-default">
					<div class="panel-body">
						<h4><?php echo $lang['menu_transactions']; ?></h4>
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
						$statement = "btc_users_transactions WHERE uid='$_SESSION[btc_uid]'";
						$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
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
							echo info($lang['info_7']);
						}
						?>

						<?php
						$ver = $settings['url']."account/transactions";
						if(web_pagination($statement,$ver,$limit,$page)) {
							echo web_pagination($statement,$ver,$limit,$page);
						}
						?>
					</div>
				</div>
			
			</div>
		</div>
	</div>