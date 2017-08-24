<div class="container-fluid page-title">
			<div class="row blue-banner">
            	<div class="container main-container">
                	<div class="col-lg-12 col-md-12 col-sm-12">
                		<h3 class="white-heading"><?php echo $lang['contact']; ?></h3>
                    </div>
                </div>
            </div> 
        </div> 
  	 <!--header section -->
	 <!-- full width section -->
    	<div class="container-fluid white-bg">
        	<div class="row">
            	<div class="container">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="content">
							<div class="row">
						<div class="col-md-12">
							<?php
							if(isset($_POST['bit_send'])) {
								$name = protect($_POST['name']);
								$email = protect($_POST['email']);
								$subject = protect($_POST['subject']);
								$message = protect($_POST['message']);
								
								if(empty($name) or empty($email) or empty($subject) or empty($message)) {
									echo error($lang['error_7']);
								} elseif(!isValidEmail($email)) {
									echo error($lang['error_8']);
								} else {
									$msubject = '['.$settings[name].'] '.$subject;
									$mreceiver = $settings['supportemail'];
									$headers = 'From: '.$supportemail.'' . "\r\n" .
										'Reply-To: '.$email.'' . "\r\n" .
										'X-Mailer: PHP/' . phpversion();
									$mail = mail($mreceiver, $msubject, $message, $headers);
									if($mail) { 
										echo success($lang['success_1']);
									} else {
										echo error($lang['error_9']);
									}
								}
							}
							?>
						</div>
						<div class="col-md-12">
							<form action="" method="POST">
								<div class="form-group">
									<label><?php echo $lang['your_name']; ?></label>
									<input type="text" class="form-control" name="name">
								</div>	
								<div class="form-group">
									<label><?php echo $lang['your_email']; ?></label>
									<input type="text" class="form-control" name="email">
								</div>	
								<div class="form-group">
									<label><?php echo $lang['subject']; ?></label>
									<input type="text" class="form-control" name="subject">
								</div>	
								<div class="form-group">
									<label><?php echo $lang['message']; ?></label>
									<textarea class="form-control" name="message" rows="3"></textarea>
								</div>	
								<button type="submit" class="btn btn-primary" name="bit_send"><?php echo $lang['btn_send_message']; ?></button>
							</form>
						</div>
					</div>
						</div>
					</div>
				</div>
			</div>
		</div>