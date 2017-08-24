<?php if(checkSession()) { $redirect = $settings['url']."account/wallet"; header("Location:$redirect"); } ?>
<div class="container-fluid login_register header_area deximJobs_tabs">
    	<div class="row">
            <div class="container main-container">
                    <div class="col-lg-offset-1 col-lg-11 col-md-12 col-sm-12 col-xs-12">
                        <ul class="nav nav-pills ">
                            <li><a href="<?php echo $settings['url']; ?>register"><?php echo $lang['register']; ?></a></li>
                            <li class="active" ><a href="<?php echo $settings['url']; ?>login"><?php echo $lang['login']; ?></a></li>
                           
                        </ul>

                    <div class="tab-content">
                        
                        <div id="login" class="tab-pane fade in active white-text">
                        	
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 zero-padding-left">
                            	<p><?php
					if(isset($_POST['btc_login'])) {
						$email = protect($_POST['email']);
						$passwd = protect($_POST['password']);
						$password = md5($passwd);
						$check = $db->query("SELECT * FROM btc_users WHERE email='$email' and password='$password'");
						if(empty($email)) { echo error($lang['error_10']); }
						elseif(empty($passwd)) { echo error($lang['error_11']); }
						elseif($check->num_rows==0) { echo error($lang['error_12']); } 
						else {
							$row = $check->fetch_assoc();
							if($row['status'] == "2") {
								echo error($lang['error_13']);
							} else {
								if($_POST['remember_me'] == "yes") {
									setcookie("bitcoinsmarket_uid", $row['id'], time() + (86400 * 30), '/'); // 86400 = 1 day
								}
								$_SESSION['btc_uid'] = $row['id'];
								$time = time();
								$update = $db->query("UPDATE btc_users SET time_signin='$time' WHERE id='$row[id]'");
								$redirect = $settings['url']."account/wallet";
								header("Location:$redirect");
							}	
						}
					}
					?></p>
                                <form method="POST" action="" class="contact_us">
                        	<div class="form-group">
                            	<label><?php echo $lang['email_address']; ?></label>
                            	<input type="text" name="email">
                            </div>
                           
                            <div class="form-group">
                            	<label><?php echo $lang['password']; ?></label>
                            	<input type="password" name="password" id="password-2"/>
                            </div>
                                                        
                            <div class="form-group submit">
                            	<label>Submit</label>
                            	<div class="cbox">
                                	<input type="checkbox" name="remember_me" value="yes"/>
                                	<span><?php echo $lang['keep_me_login']; ?></span>
                               </div>
                            </div>
                            <div class="form-group submit">
                            	<label>Submit</label>
                            	<input type="submit" name="btc_login" value="<?php echo $lang['btn_login']; ?>" class="signin" id="signin">
                                <a href="<?php echo $settings['url']; ?>password/reset" class="lost_password"><?php echo $lang['forgot_password']; ?></a>
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
	