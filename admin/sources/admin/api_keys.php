<?php
$b = protect($_GET['b']);

if($b == "add") {
	?>
	<ol class="breadcrumb">
		<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
		<li><a href="./?a=api_keys">Block.io API Keys</a></li>
		<li class="active">Add API Key</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Add API Key
		</div>
		<div class="panel-body">
			<?php
			if(isset($_POST['btn_add'])) {
				$account = protect($_POST['account']);
				$license = protect($_POST['license']);
				$secret_pin = protect($_POST['secret_pin']);
				$address = protect($_POST['address']);
				if($_POST['default_license'] == "yes") { 
					$update = $db->query("UPDATE btc_blockio_licenses SET default_license='0'");
					$default_license = '1';
				} else {
					$default_license = '0';
				}
				$check = $db->query("SELECT * FROM btc_blockio_licenses WHERE license='$license'");
				if(empty($account) or empty($license) or empty($secret_pin) or empty($address)) { echo error("All fields are required."); }
				elseif($check->num_rows>0) { echo error("This API Key already exists."); }
				else {
					$insert = $db->query("INSERT btc_blockio_licenses (account,license,secret_pin,address,default_license) VALUES ('$account','$license','$secret_pin','$address','$default_license')");
					echo success("API Key <b>$license</b> was added successfully.");
				}	
			}
			?>
			
			<form action="" method="POST">
				<div class="form-group">
					<label>Account name</label>
					<input type="text" class="form-control" name="account">
				</div>
				<div class="form-group">
					<label>API Key</label>
					<input type="text" class="form-control" name="license">
				</div>
				<div class="form-group">
					<label>Secret PIN (Your Block.io account Secret PIN)</label>
					<input type="text" class="form-control" name="secret_pin">
				</div>
				<div class="form-group">
					<label>Address (Enter here your Bitcoin address, where you will receive profits from comissions)</label>
					<input type="text" class="form-control" name="address">
				</div>
				<div class="form-group">
					<label>Default API</label>
					<select class="form-control" name="default_license">
						<option value="yes">Yes</option>
						<option type="no">No</option>
					</select>
				</div>
				<button type="submit" class="btn btn-primary" name="btn_add"><i class="fa fa-plus"></i> Add</button>
			</form>		
		</div>
	</div>
	<?php
} elseif($b == "edit") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM btc_blockio_licenses WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=api_keys"); }
	$row = $query->fetch_assoc();
	?>
	<ol class="breadcrumb">
		<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
		<li><a href="./?a=api_keys">Block.io API Keys</a></li>
		<li class="active">Edit API Key</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Edit API Key
		</div>
		<div class="panel-body">
			<?php
			if(isset($_POST['btn_save'])) {
				$account = protect($_POST['account']);
				$license = protect($_POST['license']);
				$secret_pin = protect($_POST['secret_pin']);
				$address = protect($_POST['address']);
				if($_POST['default_license'] == "yes") { 
					$update = $db->query("UPDATE btc_blockio_licenses SET default_license='0'");
					$default_license = '1';
				} else {
					$default_license = '0';
				}
				$check = $db->query("SELECT * FROM btc_blockio_licenses WHERE license='$license'");
				if(empty($account) or empty($license) or empty($secret_pin) or empty($address)) { echo error("All fields are required."); }
				elseif($row['license'] !== $license && $check->num_rows>0) { echo error("This API Key already exists."); }
				else {
					$update = $db->query("UPDATE btc_blockio_licenses SET account='$account',license='$license',secret_pin='$secret_pin',address='$address',default_license='$default_license' WHERE id='$row[id]'");
					$query = $db->query("SELECT * FROM btc_blockio_licenses WHERE id='$id'");
					$row = $query->fetch_assoc();
					echo success("Your changes was saved successfully.");
				}	
			}
			?>
			
			<form action="" method="POST">
				<div class="form-group">
					<label>Account name</label>
					<input type="text" class="form-control" name="account" value="<?php echo $row['account']; ?>">
				</div>
				<div class="form-group">
					<label>API Key</label>
					<input type="text" class="form-control" name="license" value="<?php echo $row['license']; ?>">
				</div>
				<div class="form-group">
					<label>Secret PIN (Your Block.io account Secret PIN)</label>
					<input type="text" class="form-control" name="secret_pin" value="<?php echo $row['secret_pin']; ?>">
				</div>
				<div class="form-group">
					<label>Address (Enter here your Bitcoin address, where you will receive profits from comissions)</label>
					<input type="text" class="form-control" name="address" value="<?php echo $row['address']; ?>">
				</div>
				<div class="form-group">
					<label>Default API</label>
					<select class="form-control" name="default_license">
						<option value="yes" <?php if($row['default_license'] == "1") { echo 'selected'; } ?>>Yes</option>
						<option type="no" <?php if($row['default_license'] == "0") { echo 'selected'; } ?>>No</option>
					</select>
				</div>
				<button type="submit" class="btn btn-primary" name="btn_save"><i class="fa fa-check"></i> Save changes</button>
			</form>
		</div>
	</div>
	<?php
} elseif($b == "delete") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM btc_blockio_licenses WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=api_keys"); }
	$row = $query->fetch_assoc();
	?>
	<ol class="breadcrumb">
		<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
		<li><a href="./?a=api_keys">Block.io API Key</a></li>
		<li class="active">Delete API Key</li>
	</ol>

	<div class="panel panel-danger">
		<div class="panel-heading">
			Delete API Key
		</div>
		<div class="panel-body">
			<?php
			if(isset($_GET['confirm'])) {
				$delete = $db->query("DELETE FROM btc_blockio_licenses WHERE id='$row[id]'");
				echo success("API Key <b>$row[license]</b> was deleted.");
			} else {
				echo info("Are you sure you want to delete API Key <b>$row[license]</b>?<br><small>If you delete an API Key that is the default and not select another, system will be out of action and will not work properly.</small>");
				echo '<a href="./?a=api_keys&b=delete&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=api_keys" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
		</div>
	</div>
	<?php
} else {
?>
<ol class="breadcrumb">
	<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
	<li class="active">Block.io API Keys</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Block.io API Keys
		<span class="pull-right">
			<a href="./?a=api_keys&b=add"><i class="fa fa-plus"></i> Add API Key</a>
		</span>
	</div>
	<div class="panel-body">
		<p>To add API Key need open <a href="https://block.io/" target="_blank">https://block.io/</a> and create account. Then after login click on button "Show API Keys" and copy API Key for Bitcoin. This API Key is required, because without it the system can not function.</p>
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="10%">Account name</th>
					<th width="20%">API Key</th>
					<th width="10%">Secret PIN</th>
					<th width="20%">Address</th>
					<th width="10%">Addresses</th>
					<th width="10%">Default API</th>
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
				$statement = "btc_blockio_licenses";
				$query = $db->query("SELECT * FROM {$statement} ORDER BY id LIMIT {$startpoint} , {$limit}");
				if($query->num_rows>0) {
					while($row = $query->fetch_assoc()) {
						?>
						<tr>
							<td><?php echo $row['account']; ?></td>
							<td><?php echo $row['license']; ?></td>
							<td><?php echo $row['secret_pin']; ?></td>
							<td><?php echo $row['address']; ?></td>
							<td><?php echo $row['addresses']; ?></td>
							<td><?php if($row['default_license'] == "1") { echo '<span class="text text-success"><i class="fa fa-check"></i></span>'; } else { echo '<span class="text text-danger"><i class="fa fa-times"></i></span>'; } ?></td>
							<td>
								<a href="./?a=api_keys&b=edit&id=<?php echo $row['id']; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
								<a href="./?a=api_keys&b=delete&id=<?php echo $row['id']; ?>" title="Delete"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						<?php
					}
				} else {
					echo '<tr><td colspan="7">Still no have added Block.io API Keys.</td></tr>';
				}
				?>
			</tbody>
		</table>
		<?php
		$ver = "./?a=api_keys";
		if(admin_pagination($statement,$ver,$limit,$page)) {
			echo admin_pagination($statement,$ver,$limit,$page);
		}
		?>
	</div>
</div>
<?php
}
?>