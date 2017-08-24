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
				  <a href="<?php echo $settings['url']; ?>account/trades" class="list-group-item"><i class="fa fa-refresh"></i> <?php echo $lang['menu_trades']; ?></a>
				  <a href="<?php echo $settings['url']; ?>account/settings" class="list-group-item active"><i class="fa fa-cogs"></i> <?php echo $lang['menu_settings']; ?></a>
				  
				  <a href="<?php echo $settings['url']; ?>account/verification" class="list-group-item"><i class="fa fa-check"></i> <?php echo $lang['menu_verification']; ?></a>
				</div>
				
			</div>
			<div class="col-md-9">
			
				<div class="panel panel-default">
					<div class="panel-body">
						<h4><?php echo $lang['menu_settings']; ?></h4>
						<hr/>
						<?php
						if(isset($_POST['btc_change'])) {
							$cpass = protect($_POST['cpass']);
							$npass = protect($_POST['npass']);
							$cnpass = protect($_POST['cnpass']);
							
							if(empty($cpass) or empty($npass) or empty($cnpass)) { echo error($lang['error_7']); }
							elseif(idinfo($_SESSION['btc_uid'],"password") !== md5($cpass)) { echo error($lang['error_33']); }
							elseif($npass !== $cnpass) { echo error($lang['error_34']); }
							else {
								$pass= md5($npass);
								$update = $db->query("UPDATE btc_users SET password='$pass' WHERE id='$_SESSION[btc_uid]'");
								echo success($lang['success_13']);
							}
						}
						?>
						<form action="" method="POST">
							<div class="form-group">
								<label><?php echo $lang['current_password']; ?></label>
								<input type="password" class="form-control" name="cpass">
							</div>
							<div class="form-group">
								<label><?php echo $lang['new_password']; ?></label>
								<input type="password" class="form-control" name="npass">
							</div>	
							<div class="form-group">
								<label><?php echo $lang['confirm_password']; ?></label>
								<input type="password" class="form-control" name="cnpass">
							</div>
							<button type="submit" class="btn btn-primary" name="btc_change"><i class="fa fa-check"></i> <?php echo $lang['btn_change_password']; ?></button>
						</form>
					</div>
				</div>
			
			</div>
		</div>
	</div>