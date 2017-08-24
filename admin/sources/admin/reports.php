<?php
$b = protect($_GET['b']);

if($b == "mark_readed") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM btc_trades_reports WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=reports"); }
	$row = $query->fetch_assoc();
	$user = idinfo($row['uid'],"username");
	$trade = '<a href="./?a=trades&b=explore&id='.$row[trade_id].'">#'.$row[trade_id].'</a>';
	?>
	<ol class="breadcrumb">
		<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
		<li><a href="./?a=reports">Reports</a></li>
		<li class="active">Mark as readed</li>
	</ol>

	<div class="panel panel-danger">
		<div class="panel-heading">
			Mark as readed
		</div>
		<div class="panel-body">
			<?php
			if(isset($_GET['confirm'])) {
				$delete = $db->query("UPDATE btc_trades_reports SET status='1' WHERE id='$row[id]'");
				echo success("Report <b>#$row[id]</b> was readed.");
			} else {
				echo info("Are you sure you want to mark as readed report from <b>$user</b> for trade <b>$trade</b>?");
				echo '<a href="./?a=reports&b=mark_readed&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=reports" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
		</div>
	</div>
	<?php
} elseif($b == "delete") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM btc_trades_reports WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=reports"); }
	$row = $query->fetch_assoc();
	$user = idinfo($row['uid'],"username");
	$trade = '<a href="./?a=trades&b=explore&id='.$row[trade_id].'">#'.$row[trade_id].'</a>';
	?>
	<ol class="breadcrumb">
		<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
		<li><a href="./?a=reports">Reports</a></li>
		<li class="active">Delete report</li>
	</ol>

	<div class="panel panel-danger">
		<div class="panel-heading">
			Delete report
		</div>
		<div class="panel-body">
			<?php
			if(isset($_GET['confirm'])) {
				$delete = $db->query("DELETE FROM btc_trades_reports WHERE id='$row[id]'");
				echo success("Report <b>#$row[id]</b> was deleted.");
			} else {
				echo info("Are you sure you want to delete report from <b>$user</b> for trade <b>$trade</b>?");
				echo '<a href="./?a=reports&b=delete&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=reports" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
		</div>
	</div>
	<?php
} else {
?>
<ol class="breadcrumb">
	<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
	<li class="active">Reports</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Reports
	</div>
	<div class="panel-body">
		<table class="table table-striped">
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
				$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
				$limit = 20;
				$startpoint = ($page * $limit) - $limit;
				if($page == 1) {
					$i = 1;
				} else {
					$i = $page * $limit;
				}
				$statement = "btc_trades_reports";
				$query = $db->query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}");
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
								<?php if($row['status'] == "0") { ?><a href="./?a=reports&b=mark_readed&id=<?php echo $row['id']; ?>" title="Mark as readed"><i class="fa fa-check"></i></a><?php } ?>
								<a href="./?a=reports&b=delete&id=<?php echo $row['id']; ?>" title="Delete"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						<?php
					}
				} else {
					echo '<tr><td colspan="6">Still no have reports for trades.</td></tr>';
				}
				?>
			</tbody>
		</table>
		<?php
		$ver = "./?a=reports";
		if(admin_pagination($statement,$ver,$limit,$page)) {
			echo admin_pagination($statement,$ver,$limit,$page);
		}
		?>
	</div>
</div>
<?php
}
?>