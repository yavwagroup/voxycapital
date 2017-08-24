<?php
$b = protect($_GET['b']);

if($b == "add") {
	?>
	<ol class="breadcrumb">
		<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
		<li><a href="./?a=pages">Pages</a></li>
		<li class="active">Add page</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Add page
		</div>
		<div class="panel-body">
			<?php
			if(isset($_POST['btn_add'])) {
				$title = protect($_POST['title']);
				$prefix = protect($_POST['prefix']);
				$content = $_POST['content'];
				$check = $db->query("SELECT * FROM btc_pages WHERE prefix='$prefix'");
				if(empty($title) or empty($prefix) or empty($content)) { echo error("All fields are required."); }
				elseif(!isValidUsername($prefix)) { echo error("Please enter valid prefix."); }
				elseif($check->num_rows>0) { echo error("This prefix is already used. Please choose another. "); }
				else {
					$page = $settings['url']."page/".$prefix;
					$link = '<a href="'.$page.'" target="_blank">'.$page.'</a>';
					$time = time();
					$insert = $db->query("INSERT btc_pages (title,prefix,content,created) VALUES ('$title','$prefix','$content','$time')");
					echo success("Page was created successfully. Preview link: $link");
				}	
			}
			?>
			
			<form action="" method="POST">
				<div class="form-group">
									<label>Title</label>
									<input type="text" class="form-control" name="title">
								</div>
								<div class="form-group">
									<label>Prefix</label>
									<div class="input-group">
									  <span class="input-group-addon"><?php echo $settings['url']; ?>page/</span>
									  <input type="text" class="form-control" name="prefix">
									</div>
									<small>Use latin characters and symbols - and _. Do not make spaces between words.</small>
								</div>
								<div class="form-group">
									<label>Content</label>
									<textarea class="cleditor" rows="15" name="content"></textarea>
								</div>
				<button type="submit" class="btn btn-primary" name="btn_add"><i class="fa fa-plus"></i> Add</button>
			</form>		
		</div>
	</div>
	<?php
} elseif($b == "edit") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM btc_pages WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=pages"); }
	$row = $query->fetch_assoc();
	?>
	<ol class="breadcrumb">
		<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
		<li><a href="./?a=pages">Pages</a></li>
		<li class="active">Edit page</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Edit page
		</div>
		<div class="panel-body">
			<?php
			if(isset($_POST['btn_save'])) {
				$title = protect($_POST['title']);
				$prefix = protect($_POST['prefix']);
				$content = $_POST['content'];
				if($row['prefix'] == "terms-of-services" or $row['prefix'] == "about" or $row['prefix'] == "privacy-policy") { $prefix = $row['prefix']; }
				$check = $db->query("SELECT * FROM btc_pages WHERE prefix='$prefix'");
				if(empty($title) or empty($prefix) or empty($content)) { echo error("All fields are required."); }
				elseif(!isValidUsername($prefix)) { echo error("Please enter valid prefix."); }
				elseif($row['prefix'] !== $prefix && $check->num_rows>0) { echo error("This prefix is already used. Please choose another. "); }
				else {
					$page = $settings['url']."page/".$prefix;
					$link = '<a href="'.$page.'" target="_blank">'.$page.'</a>';
					$time = time();
					$update = $db->query("UPDATE btc_pages SET title='$title',prefix='$prefix',content='$content',updated='$time' WHERE id='$row[id]'");
					$query = $db->query("SELECT * FROM btc_pages WHERE id='$id'");
					$row = $query->fetch_assoc();
					echo success("Page was updated successfully. Preview link: $link");
				}	
			}
			?>
			
			<form action="" method="POST">
					<div class="form-group">
									<label>Title</label>
									<input type="text" class="form-control" name="title" value="<?php echo $row['title']; ?>">
								</div>
								<div class="form-group">
									<label>Prefix</label>
									<div class="input-group">
									  <span class="input-group-addon"><?php echo $settings['url']; ?>page/</span>
									  <input type="text" class="form-control" <?php if($row['prefix'] == "terms-of-services" or $row['prefix'] == "about" or $row['prefix'] == "privacy-policy") { echo 'disabled'; } ?> name="prefix" value="<?php echo $row['prefix']; ?>">
									</div>
									<small>Use latin characters and symbols - and _. Do not make spaces between words.</small>
								</div>
								<div class="form-group">
									<label>Content</label>
									<textarea class="cleditor" rows="15" name="content"><?php echo $row['content']; ?></textarea>
								</div>
				<button type="submit" class="btn btn-primary" name="btn_save"><i class="fa fa-check"></i> Save changes</button>
			</form>
		</div>
	</div>
	<?php
} elseif($b == "delete") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM btc_pages WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=pages"); }
	$row = $query->fetch_assoc();
	if($row['prefix'] == "terms-of-services" or $row['prefix'] == "about" or $row['prefix'] == "privacy-policy") {
		header("Location: ./?a=pages");
	}
	?>
	<ol class="breadcrumb">
		<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
		<li><a href="./?a=pages">Pages</a></li>
		<li class="active">Delete page</li>
	</ol>

	<div class="panel panel-danger">
		<div class="panel-heading">
			Delete page
		</div>
		<div class="panel-body">
			<?php
			if(isset($_GET['confirm'])) {
				$delete = $db->query("DELETE FROM btc_pages WHERE id='$row[id]'");
				echo success("Page <b>$row[title]</b> was deleted.");
			} else {
				echo info("Are you sure you want to delete page <b>$row[title]</b>?");
				echo '<a href="./?a=pages&b=delete&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=pages" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
		</div>
	</div>
	<?php
} else {
?>
<ol class="breadcrumb">
	<li><a href="./"><?php echo $settings['name']; ?> Administrator</a></li>
	<li class="active">Pages</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Pages
		<span class="pull-right">
			<a href="./?a=pages&b=add"><i class="fa fa-plus"></i> Add page</a>
		</span>
	</div>
	<div class="panel-body">
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="30%">Title</th>
					<th width="20%">Prefix</th>
					<th width="20%">Created on</th>
					<th width="20%">Updated on</th>
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
				$statement = "btc_pages";
				$query = $db->query("SELECT * FROM {$statement} ORDER BY id LIMIT {$startpoint} , {$limit}");
				if($query->num_rows>0) {
					while($row = $query->fetch_assoc()) {
						?>
						<tr>
							<td><?php echo $row['title']; ?></td>
							<td><?php echo $row['prefix']; ?></td>
							<td><?php if($row['created']) { echo '<span class="label label-default">'.date("d/m/Y H:i:s".$row[created]).'</span>'; } else { echo '-'; } ?></td>
							<td><?php if($row['updated']) { echo '<span class="label label-default">'.date("d/m/Y H:i:s".$row[updated]).'</span>'; } else { echo '-'; } ?></td>
							<td>
								<a href="./?a=pages&b=edit&id=<?php echo $row['id']; ?>" title="Edit"><i class="fa fa-pencil"></i></a> 
								<?php if($row['prefix'] == "terms-of-services" or $row['prefix'] == "about" or $row['prefix'] == "privacy-policy") { } else { ?>
								<a href="./?a=pages&b=delete&id=<?php echo $row['id']; ?>" title="Delete"><i class="fa fa-times"></i></a>
								<?php } ?>
							</td>
						</tr>
						<?php
					}
				} else {
					echo '<tr><td colspan="4">Still no have rates. <a href="./?a=rates&b=add">Click here</a> to add.</td></tr>';
				}
				?>
			</tbody>
		</table>
		<?php
		$ver = "./?a=rates";
		if(admin_pagination($statement,$ver,$limit,$page)) {
			echo admin_pagination($statement,$ver,$limit,$page);
		}
		?>
	</div>
</div>
<?php
}
?>