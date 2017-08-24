<?php
$b = protect($_GET['b']);

if($b == "explore") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM btc_trades WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=trades"); }
	$row = $query->fetch_assoc();
	if($row['type'] == "sell") {
												if($row['status'] == "1") {
													$status =  '<span class="text text-info">Client create trade request. Awaiting action from trader.</span>';
												} elseif($row['status'] == "2") {
													$status = '<span class="text text-info">Trader make payment. Awaiting action from client.</span>';
												} elseif($row['status'] == "3") {
													$status = '<span class="text text-info">Client release bitcoins.</span>';
												} elseif($row['status'] == "4") {
													$status = '<span class="text text-danger">Trader cancel trade</span>';
												} elseif($row['status'] == "5") {
													$status = '<span class="text text-danger">Client cancel trade</span>';
												} elseif($row['status'] == "6") {
													$status = '<span class="text text-danger">Trade expired</span>';
												} elseif($row['status'] == "7") {
													$status = '<span class="text text-success">Trade completed</span>';
												} else {
													$status = '<span class="text text-default">Unknown</span>';
												}
											} else {
												if($row['status'] == "1") {
													$status =  '<span class="text text-info">Client create trade request. Awaiting action from client.</span>';
												} elseif($row['status'] == "2") {
													$status = '<span class="text text-info">Client make payment. Awaiting action from trader.</span>';
												} elseif($row['status'] == "3") {
													$status = '<span class="text text-info">Trader release bitcoins.</span>';
												} elseif($row['status'] == "4") {
													$status = '<span class="text text-danger">Trader cancel trade</span>';
												} elseif($row['status'] == "5") {
													$status = '<span class="text text-danger">Client cancel trade</span>';
												} elseif($row['status'] == "6") {
													$status = '<span class="text text-danger">Trade expired</span>';
												} elseif($row['status'] == "7") {
													$status = '<span class="text text-success">Trade completed</span>';
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
	?>
	<ol class="breadcrumb">
		<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
		<li><a href="./?a=trades">Trades</a></li>
		<li class="active">Explore</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Explore
		</div>
		<div class="panel-body">
			<div class="sdf">
				<div class="container">
					<div class="col-md-12" style="margin-top:10px;margin-bottom:30px;"	>	
						<div class="row">
							<div class="col-md-12">
								<span style="color:#c1c1c1;font-size:35px;font-weight:bold;">Trade #<?php echo $row['id']; ?> <small>from advertisement <a href="<?php echo $adlink; ?>">#<?php echo $row['ad_id']; ?></a>, Bitcoin Price <?php echo $row['btc_price']; ?> <?php echo adinfo($row['ad_id'],"currency"); ?>/BTC</span><br/>
								<span style="color:#c1c1c1;font-size:25px;">Trade amount: <b><?php echo $row['amount']; ?> <?php echo adinfo($row['ad_id'],"currency"); ?></b> (<?php echo $row['btc_amount']; ?> BTC)</span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<hr/>
			<?php
			if(isset($_POST['btc_release_bitcoins'])) {
				if($row['type'] == "sell") {
					if($row['released_bitcoins'] !== "1") {
						$update = $db->query("UPDATE btc_trades SET status='7',released_bitcoins='1' WHERE id='$row[id]'");
						$uaddress = walletinfo($row['uid'],"address");
						$taddress = walletinfo($row['trader'],"address");
						$lid = walletinfo($_SESSION['btc_uid'],"lid");
						$license_query = $db->query("SELECT * FROM btc_blockio_licenses WHERE id='$lid' ORDER BY id");
						$license = $license_query->fetch_assoc();
						$apiKey = $license['license'];
						$pin = $license['secret_pin'];
						$version = 2; // the API version
						$block_io = new BlockIo($apiKey, $pin, $version);
						$withdrawal = $block_io->withdraw_from_addresses(array('amounts' => $row[btc_amount], 'from_addresses' => $uaddress, 'to_addresses' => $taddress));
						$withdrawal = $block_io->withdraw_from_addresses(array('amounts' => $settings[sell_comission], 'from_addresses' => $uaddress, 'to_addresses' => $license[address]));
						echo success("Thank you! Bitcoins was released and trade is completed.");
						$query = $db->query("SELECT * FROM btc_trades WHERE id='$row[id]'");
						$row = $query->fetch_assoc();
					}
				} elseif($row['type'] == "buy") {
					if($row['released_bitcoins'] !== "1") {
						$update = $db->query("UPDATE btc_trades SET status='7',released_bitcoins='1' WHERE id='$row[id]'");
						$uaddress = walletinfo($row['uid'],"address");
						$taddress = walletinfo($row['trader'],"address");
						$lid = walletinfo($_SESSION['btc_uid'],"lid");
						$license_query = $db->query("SELECT * FROM btc_blockio_licenses WHERE id='$lid' ORDER BY id");
						$license = $license_query->fetch_assoc();
						$apiKey = $license['license'];
						$pin = $license['secret_pin'];
						$version = 2; // the API version
						$block_io = new BlockIo($apiKey, $pin, $version);
						$withdrawal = $block_io->withdraw_from_addresses(array('amounts' => $row[btc_amount], 'from_addresses' => $taddress, 'to_addresses' => $uaddress));
						$withdrawal = $block_io->withdraw_from_addresses(array('amounts' => $settings[buy_comission], 'from_addresses' => $taddress, 'to_addresses' => $license[address]));
						echo success("Thank you! Bitcoins was released and trade is completed.");
						$query = $db->query("SELECT * FROM btc_trades WHERE id='$row[id]'");
						$row = $query->fetch_assoc();
						}
				} else { }
			}
			?>
			<table class="table table-striped">
				<tbody>
					<tr>
						<td colspan="2">Status: <?php echo $status; ?></td>
					</tr>
					<tr>
						<td>Client: <?php echo idinfo($row['uid'],"username"); ?></td>
						<td>Trader: <?php echo idinfo($row['trader'],"username"); ?></td>
					</tr>
				</tbody>
			</table>
			<?php
			if($row['released_bitcoins'] == "0") {
			?>
			<form action="" method="POST">
				<button type="submit" class="btn btn-success" name="btc_release_bitcoins"><i class="fa fa-check"></i> Release bitcoins</button> 	
			</form>
			<?php
			}
			?>
		</div>
	</div>
	<?php
} elseif($b == "delete") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM btc_trades WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=trades"); }
	$row = $query->fetch_assoc();
	?>
	<ol class="breadcrumb">
		<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
		<li><a href="./?a=trades">Trades</a></li>
		<li class="active">Delete trade</li>
	</ol>

	<div class="panel panel-danger">
		<div class="panel-heading">
			Delete trade
		</div>
		<div class="panel-body">
			<?php
			if(isset($_GET['confirm'])) {
				$delete = $db->query("DELETE FROM btc_trades WHERE id='$row[id]'");
				echo success("Trade <b>#$row[id]</b> was deleted.");
			} else {
				echo info("Are you sure you want to delete trade <b>#$row[id]</b>?");
				echo '<a href="./?a=trades&b=delete&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=trades" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
		</div>
	</div>
	<?php
} else {
?>
<ol class="breadcrumb">
	<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
	<li class="active">Trades</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Trades
	</div>
	<div class="panel-body">
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="5%">ID</th>
					<th width="10%">Ad ID</th>
					<th width="15%">Amount</th>
					<th width="10%">Type</th>
					<th width="15%">Client</th>
					<th width="15%">Trader</th>
					<th width="10%">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
				$limit = 20;
				$startpoint = ($page * $limit) - $limit;
				if($page == 1) {
					$i = 1;
				} else {
					$i = $page * $limit;
				}
				if($b == "by_user") {
					$uid = protect($_GET['uid']);
					$statement = "btc_trades WHERE uid='$uid'";
					$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");

				} else {
					$statement = "btc_trades";
					$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
				}
				if($query->num_rows>0) {
					while($row = $query->fetch_assoc()) {
						?>
							<tr>
							<td><?php echo $row['id']; ?></td>
							<td><a href="./?a=advertisements&b=edit&id=<?php echo $row['ad_id']; ?>">#<?php echo $row['ad_id']; ?></a></td>
							<td><b><?php echo $row['amount']; ?> <?php echo adinfo($row['ad_id'],"currency"); ?></b> (<?php echo $row['btc_amount']; ?> BTC)</td>
							<td><?php if($row['type'] == "buy") { echo 'Client SELL'; } else { echo 'Client BUY'; }  ?></td>
							<td><a href="./?a=users&b=edit&id=<?php echo $row['uid']; ?>"><?php echo idinfo($row['uid'],"username"); ?></a></td>
							<td><a href="./?a=users&b=edit&id=<?php echo $row['trader']; ?>"><?php echo idinfo($row['trader'],"username"); ?></a></td>
							<td>
								<a href="./?a=trades&b=explore&id=<?php echo $row['id']; ?>" title="Explore"><i class="fa fa-search"></i> Explore</a>
								<a href="./?a=trades&b=delete&id=<?php echo $row['id']; ?>" title="Delete"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						<?php
					}
				} else {
					echo '<tr><td colspan="4">Still no have faq.</td></tr>';
				}
				?>
			</tbody>
		</table>
		<?php
		$ver = "./?a=faq";
		if(admin_pagination($statement,$ver,$limit,$page)) {
			echo admin_pagination($statement,$ver,$limit,$page);
		}
		?>
	</div>
</div>
<?php
}
?>