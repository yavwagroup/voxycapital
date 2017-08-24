
<ol class="breadcrumb">
	<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
	<li class="active">Transactions</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Transactions
		<span class="pull-right">
			<form action="" method="POST">
				<input type="text" class="input_search" name="qry" placeholder="Search...">
			</form>
		</span>
	</div>
	<div class="panel-body">
				<?php
				$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
				$limit = 20;
				$startpoint = ($page * $limit) - $limit;
				if($page == 1) {
					$i = 1;
				} else {
					$i = $page * $limit;
				}
				if(isset($_POST['qry'])) { 
					$searching = 1;
					$qry = protect($_POST['qry']);
					if(empty($qry)) { $qry = "empty field"; }
					$statement = "btc_users_transactions WHERE txid LIKE '%$qry%' or sender LIKE '%$qry%' or recipient LIKE '%$qry%'";
					$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC");
				} elseif($_GET['b'] == "by_user") {
					$searching = 2;
					$uid = protect($_GET['uid']);
					$statement = "btc_users_transactions WHERE uid='$uid'";
					$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
				} else { 
					$searching = 0;
					$statement = "btc_users_transactions";
					$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
				}
				if($query->num_rows>0) {
					while($row = $query->fetch_assoc()) {
						?>
						<div class="panel panel-default">
										<div class="panel-body">
											<div class="row">
												<div class="col-md-2 text-center">
													<?php
													if($row['type'] == "sent") {
														echo '<span class="text text-danger text-center"><i class="fa fa-arrow-circle-o-up fa-2x"></i><br/>Sent</span>';
													} else {
														echo '<span class="text text-success text-center"><i class="fa fa-arrow-circle-o-down fa-2x"></i><br/>Received</span>';
													}
													?>
													<br><br>
													<span class="text-muted"><small><?php echo $row['confirmations']." confirmations"; ?></small></span>
												</div>
												<div class="col-md-10">
													<table class="table table-striped">
														<tbody>
															<tr>
																<td>User:</td>
																<td><a href="./?a=transactions&b=by_user&uid=<?php echo $row['uid']; ?>"><?php echo idinfo($row['uid'],"username"); ?></a></td>
															</tr>
															<tr>
																<td>Transaction:</td>
																<td><a href="https://chain.so/tx/BTC/<?php echo $row['txid']; ?>"><?php echo $row['txid']; ?></a></td>
															</tr>	
															<tr>
																<td>Sender:</td>
																<td><?php echo $row['sender']; ?></td>
															</tr>
															<tr>
																<td>Recipient:</td>
																<td><?php echo $row['recipient']; ?></td>
															</tr>
															<tr>
																<td>Amount:</td>
																<td><?php echo $row['amount']; ?> BTC</td>
															</tr>
															<tr>
																<td>Time:</td>
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
					if($searching == "1") {
						echo info("No found results for <b>$qry</b>."); 
					} elseif($searching == "2") {
						$uid = protect($_GET['uid']);
						$user = idinfo($uid,"username");
						echo info("<b>$user</b> no have transactions yet."); 
					} else {
						echo 'No have transactions by users.';
					}
				}
				?>
				
		<?php
		$ver = "./?a=transactions";
		if(admin_pagination($statement,$ver,$limit,$page)) {
			echo admin_pagination($statement,$ver,$limit,$page);
		}
		?>
	</div>
</div>