<ol class="breadcrumb">
	<li><a href="./"><?php echO $settings['name']; ?> Administrator</a></li>
	<li class="active">Dashboard</li>
</ol>

<div class="row">
	<div class="col-lg-3">
		 <div class="panel panel-default twitter">
                    <div class="panel-body fa-icons">
                        <small class="social-title">Users</small>
                        <h3 class="count">
                            <?php $get_stats = $db->query("SELECT * FROM btc_users"); echo $get_stats->num_rows; ?></h3>
                        <i class="fa fa-users"></i>
                    </div>
                </div>
	</div>
	<div class="col-lg-3">
		<div class="panel panel-default google-plus">
                    <div class="panel-body fa-icons">
                        <small class="social-title">Advertisements</small>
                        <h3 class="count">
                            <?php $get_stats = $db->query("SELECT * FROM btc_ads"); echo $get_stats->num_rows; ?></h3>
                        <i class="fa fa-globe"></i>
                    </div>
                </div>
	</div>
	<div class="col-lg-3">
		<div class="panel panel-default facebook-like">
                    <div class="panel-body fa-icons">
                        <small class="social-title">Trades</small>
                        <h3 class="count">
                            <?php $get_stats = $db->query("SELECT * FROM btc_trades"); echo $get_stats->num_rows; ?></h3>
                        <i class="fa fa-exchange"></i>
                    </div>
                </div>
	</div>
	<div class="col-lg-3">
		<div class="panel panel-default visitor">
                    <div class="panel-body fa-icons">
                        <small class="social-title">Your profit</small>
                        <h3 class="count" style="font-size:25px;padding-top:6px;padding-bottom:6px;">
                            <?php echo admin_get_profit(); ?></h3>
                        <i class="fa fa-dollar"></i>
                    </div>
                </div>
	</div>
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">Trades at this moment</div>
			<div class="panel-body">
				<table class="table">
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
			  $t=1;
			  $query = $db->query("SELECT * FROM btc_trades WHERE status <= '3' ORDER BY id DESC");
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
							</td>
						</tr>
				<?php 
				$t++;
				}
			  } else {
				echo '<tr><td colspan="7">No have active trades.</td></tr>';
			  }
			  ?>
		      </tbody>
		    </table>
			</div>	
		</div>
		
				<br>
		<div class="panel panel-primary">
			<div class="panel-heading">New reports</div>
			<div class="panel-body">
				<table class="table">
		      <thead>
		        <tr>
					<th width="5%">ID</th>
					<th width="15%">User</th>
					<th width="10%">Trade ID</th>
					<th width="30%">Message</th>
					<th width="10%">Time</th>
					<th width="10%">Action</th>
				</tr>
		      </thead>
		      <tbody>
		      <?php
			  $i=1;
			  $query = $db->query("SELECT * FROM btc_trades_reports WHERE status='0' ORDER BY id DESC");
			  if($query->num_rows>0) {
			    while($row = $query->fetch_assoc()) {
				?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td><a href="./?a=users&b=edit&id=<?php echo $row['uid']; ?>"><?php echo idinfo($row['uid'],"username"); ?></a></td>
							<td><a href="./?a=trades&b=preview&id=<?php echo $row['trade_id']; ?>">#<?php echo $row['trade_id']; ?></a></td>
							<td><?php echo $row['content']; ?></td>
							<td><?php echo date("d/m/Y H:i",$row['time']); ?></td>
							<td>
								<a href="./?a=reports&b=mark_readed&id=<?php echo $row['id']; ?>" title="Mark as readed"><i class="fa fa-check"></i></a>
								<a href="./?a=reports&b=delete&id=<?php echo $row['id']; ?>" title="Delete"><i class="fa fa-times"></i></a>
							</td>
						</tr>
				<?php 
				$i++;
				}
			  } else {
				echo '<tr><td colspan="6">No have new reports.</td></tr>';
			  }
			  ?>
		      </tbody>
		    </table>
			
			</div>	
		</div>
				<?php
		$query = $db->query("SELECT * FROM btc_users WHERE document_1 != '' and document_verified='0' ORDER BY id");
		if($query->num_rows>0) {
		?>
		<br>
		<div class="panel panel-primary">
			<div class="panel-heading">Pending documents for approval</div>
			<div class="panel-body">
				<table class="table">
		      <thead>
		        <tr>
					<th width="5%">ID</th>
					<th width="15%">Username</th>
					<th width="15%">Email address</th>
					<th width="15%">Document 1</th>
					<th width="15%">Document 2</th>
					<th width="15%">Registered on</th>
					<th width="10%">Action</th>
				</tr>
		      </thead>
		      <tbody>
		      <?php
			    while($row = $query->fetch_assoc()) {
				?>
						<tr>
							<td><?php echo $row['id']; ?></td>
							<td><?php echo $row['username']; ?></td>
							<td><?php echo $row['email']; ?></td>
							<td><a href="<?php echo $settings['url'].$row['document_1']; ?>" target="_blank"><?php echo basename($row['document_1']); ?></a></td>
							<td><a href="<?php echo $settings['url'].$row['document_2']; ?>" target="_blank"><?php echo basename($row['document_2']); ?></a></td>
							<td><span class="label label-primary"><?php echo date("d/m/Y H:i:s",$row['time_signup']); ?></span></td>
							<td>
								<a href="./?a=users&b=edit&id=<?php echo $row['id']; ?>" title="Approve"><i class="fa fa-check"></i></a>
							</td>
						</tr>
				<?php 
				$i++;
				}
			  ?>
		      </tbody>
		    </table>
			
			</div>	
		</div>
		<?php
		}
		?>
	</div>
</div>