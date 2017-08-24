<?php
$username = protect($_GET['username']);
$uquery = $db->query("SELECT * FROM btc_users WHERE username='$username'");
if($uquery->num_rows==0) { header("Location: $settings[url]"); }
$user = $uquery->fetch_assoc();
$advertisementsQuery = $db->query("SELECT * FROM btc_ads WHERE uid='$user[id]'");
$tradesQuery = $db->query("SELECT * FROM btc_trades WHERE uid='$user[id]' or trader='$user[id]'");
?>
	<div class="container-fluid page-title">
			<div class="row blue-banner">
            	<div class="container main-container">
                	<div class="col-lg-12 col-md-12 col-sm-12">
							<h2 class="white-heading"><i class="fa fa-user"></i> <b><?php echo $user['username']; ?></b> <small style="color:#fff;">- <?php echo activity_time($user['id']); ?></small></h2>
							<h4 style="color:#fff;"><i class="fa fa-globe"></i> <?php echo $advertisementsQuery->num_rows; ?> <?php echo $lang['advertisements']; ?>, <i class="fa fa-refresh"></i> <?php echo $tradesQuery->num_rows; ?> <?php echo $lang['trades']; ?></h4>
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
		<div class="row">
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3><?php echo $lang['aadvertisements']; ?></h3>
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="30%"><?php echo $lang['ad_type']; ?></th>
									<th width="25%"><?php echo $lang['payment_method']; ?></th>
									<th width="20%"><?php echo $lang['price']; ?></th>
									<th width="20%"><?php echo $lang['limits']; ?></th>
									<th width="5%"></th>
								</tr>
							</thead>
							<tbody style="font-size:14px;">
								<?php
								$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
								$limit = 2;
								$startpoint = ($page * $limit) - $limit;
								if($page == 1) {
									$i = 1;
								} else {
									$i = $page * $limit;
								}
								$statement = "btc_ads WHERE uid='$user[id]'";
								$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC");
								if($query->num_rows>0) {
										while($row = $query->fetch_assoc()) {
										$pm = str_ireplace(" ","-",$row['payment_method']);
										?>
										<tr>
											<td><?php if($row['type'] == "sell") { echo $lang['buy_bitcoins']; } elseif($row['type'] == "buy") { echo $lang['sell_bitcoins']; } else { } ?></td>
											<td><?php echo $row['payment_method']; ?></td>
											<td><?php echo convertBTCprice($row['price'],$row['currency']); ?> <?php echo $row['currency']; ?>/BTC</td>
											<td><?php echo $row['min_amount']; ?> - <?php echo $row['max_amount']; ?> <?php echo $row['currency']; ?></td>
											<?php if($row['type'] == "sell") { ?>
											<td><a href="<?php echo $settings['url'];?>ad/<?php echo $pm; ?>-to-Bitcoin/<?php echo $row['id']; ?>" class="btn btn-default btn-xs"><?php echo $lang['btn_buy']; ?></a></td>
											<?php } elseif($row['type'] == "buy") { ?>
											<td><a href="<?php echo $settings['url'];?>ad/Bitcoin-to-<?php echo $pm; ?>/<?php echo $row['id']; ?>" class="btn btn-default btn-xs"><?php echo $lang['btn_sell']; ?></a></td>
											<?php } else { } ?>
										</tr>
										<?php
									}
								} else {
									echo '<tr><td colspan="5">'.$lang[no_ad_for_display].'</td></tr>';
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<h3><?php echo $lang['latest_feedbacks']; ?></h3>
						<?php
						$queryFeedbacks = $db->query("SELECT * FROM btc_users_ratings WHERE uid='$user[id]' ORDER BY id DESC LIMIT 5");
						if($queryFeedbacks->num_rows>0) {
							while($fb = $queryFeedbacks->fetch_assoc()) {
								$adid = tradeinfo($fb['trade_id'],"ad_id");
								$adpaymentmethod = adinfo($adid,"payment_method");
								$adtype = adinfo($adid,"type");
								if($adtype == "buy") {
									$pm = str_ireplace(" ","-",$adpaymentmethod);
									$adlink = $settings['url']."ad/Bitcoin-to-".$pm."/".$adid;
								} elseif($adtype == "sell") {
									$pm = str_ireplace(" ","-",$adpaymentmethod);
									$adlink = $settings['url']."ad/".$pm."-to-Bitcoin/".$adid;
								} else { }
								?>
								<div class="row">
									<div class="col-md-2">
										<?php if($fb['type'] == "1") { ?>
										<span class="text text-success"><i class="fa fa-smile-o fa-3x"></i></span>
										<?php } elseif($fb['type'] == "2") { ?>
										<span class="text text-warning"><i class="fa fa-meh-o fa-3x"></i></span>
										<?php } elseif($fb['type'] == "3") { ?>
										<span class="text text-danger"><i class="fa fa-frown-o fa-3x"></i></span>
										<?php } else { } ?>
									</div>
									<div class="col-md-10">
										<a href="<?php echo $settings['url']; ?>user/<?php echo idinfo($fb['author'],"username"); ?>"><?php echo idinfo($fb['author'],"username"); ?></a> <i class="fa fa-angle-right"></i> <a href="<?php echo $settings['url']; ?>user/<?php echo idinfo($fb['uid'],"username"); ?>"><?php echo idinfo($fb['uid'],"username"); ?></a><br/>
										<p><?php echo $fb['comment']; ?></p>
										<?php echo $lang['for_advertisements']; ?> <a href="<?php echo $adlink; ?>">#<?php echo $adid; ?></a>
									</div>
								</div>	
								<hr/>
								<?php
							}
						} else {
							echo $lang['no_feedbacks_yet'];
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
		</div>>