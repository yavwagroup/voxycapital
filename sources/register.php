<?php if(checkSession()) { $redirect = $settings['url']."account/wallet"; header("Location:$redirect"); } ?>
<div class="container-fluid login_register header_area deximJobs_tabs">
    	<div class="row">
            <div class="container main-container">
                    <div class="col-lg-offset-1 col-lg-11 col-md-12 col-sm-12 col-xs-12">
                        <ul class="nav nav-pills ">
                            <li class="active"><a  href="<?php echo $settings['url']; ?>register"><?php echo $lang['register']; ?></a></li>
                            <li><a href="<?php echo $settings['url']; ?>login"><?php echo $lang['login']; ?></a></li>
                           
                        </ul>

                    <div class="tab-content">
                        <div id="register-account" class="tab-pane fade in active white-text">
                        	
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 zero-padding-left">
                            	<p><?php
					if(isset($_POST['btc_register'])) {
						$username = protect($_POST['username']);
						$email = protect($_POST['email']);
						$password = protect($_POST['password']);
						$cpassword = protect($_POST['cpassword']);
						$secret_pin = protect($_POST['secret_pin']);
						$check_u = $db->query("SELECT * FROM btc_users WHERE username='$username'");
						$check_e = $db->query("SELECT * FROM btc_users WHERE email='$email'");
						
						if(empty($username) or empty($email) or empty($password) or empty($cpassword) or empty($secret_pin)) { echo error($lang['error_7']); }
						elseif(!isValidUsername($username)) { echo error($lang['error_18']); }
						elseif($check_u->num_rows>0) { echo error($lang['error_19']); }
						elseif(strlen($username)<6) { echo error($lang['error_20']); }
						elseif(!isValidEmail($email)) { echo error($lang['error_21']); }
						elseif($check_e->num_rows>0) { echo error($lang['error_22']); }
						elseif(strlen($password)<8) { echo error($lang['error_23']); }
						elseif($password !== $cpassword) { echo error($lang['error_24']); }
						elseif(strlen($secret_pin)<4) { echo error($lang['error_25']); }
						else {
							$passwd = md5($password);
							$time = time();
							$ip = $_SERVER['REMOTE_ADDR'];
							$hash = md5($email);
							if($_SESSION['refid']) { $refid = $_SESSION['ref_id']; } else { $refid = '0'; }
							$insert = $db->query("INSERT btc_users (username,password,secret_pin,email,status,hash,ip,time_signup,referral_id) VALUES ('$username','$passwd','$secret_pin','$email','3','$hash','$ip','$time','$refid')");
							echo success($lang['success_4']);
							btc_generate_address($username);
							emailsys_verification_email($username);
						}
					}
					?></p>
                                        <form action="" method="POST" class="contact_us">
                                            <div class="form-group">
                                                <label><?php echo $lang['username']; ?></label>
                                                <input type="text" name="username">
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $lang['email_address']; ?></label>
                                                <input type="email" name="email">
                                            </div>
                                            <div class="form-group">
                                                <label><?php echo $lang['password']; ?></label>
                                                <input type="password" name="password" id="password"/>
                                            </div>
                                             <div class="form-group">
                                                <label><?php echo $lang['confirm_password']; ?></label>
                                                <input type="password" name="cpassword" id="cpassword"/>
                                            </div>
											<div class="form-group">
                                                <label><?php echo $lang['secret_pin']; ?></label>
                                                <input type="password" name="secret_pin" id="cpassword"/>
                                            </div>
                                   
                                         
                                    
                                            <div class="form-group submit">
                                                <label>Submit</label>
                                                <input type="submit" name="btc_register" value="<?php echo $lang['btn_register']; ?>" class="register">
                                                <a href="<?php echo $settings['url']; ?>password/reset" class="lost_password"><?php echo $lang['forgot_password']; ?></a>
                                            </div>
                                 </form>
                        	</div>
                            <div class="col-lg-4 col-md-5 col-sm-6 col-xs-12  pull-right sidebar">
                            	<div class="widget">
                                	<h3><?php echo $lang['why_to_have_account_in']; ?> <?php echo $settings['name']; ?>? </h3>
                                    <ul>
                                    	<li><p><i class="fa fa-clock-o"></i> <?php echo $lang['why_info_1']; ?></p></li>
										<li><p><i class="fa fa-child"></i> <?php echo $lang['why_info_2']; ?></p></li>

                                    </ul>
                                   
                           		</div> 
                            </div>
                        </div>
                        
                       
                    </div>
                        
                        
                    </div>
                    
			</div>
       </div>
    </div> 
	