<?php if(checkSession()) { $redirect = $settings['url']."account/wallet"; header("Location:$redirect"); } ?>
 
    <div class="container-fluid login_register header_area deximJobs_tabs">
    	<div class="row">
            <div class="container main-container">
                    <div class="col-lg-offset-1 col-lg-11 col-md-12 col-sm-12 col-xs-12">
                        <ul class="nav nav-pills ">
                            <li class="active"><a href="<?php echo $settings['url']; ?>password/reset"><?php echo $lang['forgot_password']; ?></a></li>
                        </ul>

                    <div class="tab-content">
                        <div id="lost-password" class="tab-pane fade in active white-text">
                        	
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 zero-padding-left">
                            	<p><?php
					if(isset($_POST['btc_reset'])) {
						$email = protect($_POST['email']);
						$hash = randomHash(15);
						$check_e = $db->query("SELECT * FROM btc_users WHERE email='$email'");
						if($check_e->num_rows>0) {
							$row = $check_e->fetch_assoc();
							$update = $db->query("UPDATE btc_users SET hash='$hash' WHERE id='$row[id]'");
							emailsys_reset_password($row['id']);
							echo success($lang['success_11']);
						} else {
							echo error($lang['error_32']);
						}
					}
					?></p>
                                <form action="" method="POST" class="contact_us">
                        	<div class="form-group">
                            	<label><?php echo $lang['email_address']; ?></label>
                            	<input type="text" name="email">
                            </div>
                            <div class="form-group submit">
                            	<label>Submit</label>
                            	<input type="submit" name="btc_reset" value="<?php echo $lang['btn_reset']; ?>" class="signin" id="signin">
                              
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