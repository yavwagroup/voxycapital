<?php 
if(checkSession()) { $redirect = $settings['url']."account/wallet"; header("Location:$redirect"); } 
$hash = protect($_GET['hash']);
$query = $db->query("SELECT * FROM btc_users WHERE hash='$hash'");
if($query->num_rows==0) { header("Location: $settings[url]"); }
$row = $query->fetch_assoc();
?>
<div class="container-fluid login_register header_area deximJobs_tabs">
    	<div class="row">
            <div class="container main-container">
                    <div class="col-lg-offset-1 col-lg-11 col-md-12 col-sm-12 col-xs-12">
                        <ul class="nav nav-pills ">
                            <li class="active"><a href="<?php echo $settings['url']; ?>password/reset"><?php echo $lang['change_password']; ?></a></li>
                        </ul>

                    <div class="tab-content">
                        <div id="lost-password" class="tab-pane fade in active white-text">
                        	
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 zero-padding-left">
                            	<p><?php
					if(isset($_POST['btc_change'])) {
						$password = protect($_POST['password']);
						$cpassword = protect($_POST['cpassword']);
						if(empty($password) or empty($cpassword)) { echo error($lang['error_29']); }
						elseif(strlen($password)<8) { echo error($lang['error_30']); }
						elseif($password !== $cpassword) { echo error($lang['error_31']); }
						else {
							$passwd = md5($password);
							$update = $db->query("UPDATE btc_users SET hash='',password='$passwd' WHERE id='$row[id]'");
							echo success($lang['success_10']);
							$hide_form=1;
						}
					}
					?></p>
                                <form action="" method="POST" class="contact_us">
                        	<div class="form-group">
                            	<label><?php echo $lang['username']; ?></label>
                            	<input type="text" name="username" disabled value="<?php echo $row['username']; ?>">
                            </div>
							<div class="form-group">
							<label ><?php echo $lang['new_password']; ?></label>
							<input type="password" name="password">
						</div>
						<div class="form-group">
							<label><?php echo $lang['confirm_password']; ?></label>
							<input type="password"  name="cpassword">
						</div>
                            <div class="form-group submit">
                            	<label>Submit</label>
                            	<input type="submit" name="btc_change" value="<?php echo $lang['btn_change']; ?>" class="signin" id="signin">
                              
                            </div>
                           
                        
                        	</form>
                        	</div>
                            <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12  pull-right sidebar">
                            	<div class="widget">
                                	<h3><?php echo $lang['no_have_account']; ?></h3>
                                    <ul>
                                    	<li>
                                        <p><?php echo $lang['register_info']; ?></p></li>
										<li>
                                        <a href="<?php echo $settings['url']; ?>register" class="label job-type register"><?php echo $lang['register']; ?></a>
                                        
                                        </li>
                                    </ul>
                                   
                           		</div> 
                            </div>
                        </div>
                       
                    </div>
                        
                        
                    </div>
                    
			</div>
       </div>
    </div> 