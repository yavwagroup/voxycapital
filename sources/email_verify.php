<?php if(checkSession()) { $redirect = $settings['url']."account/wallet"; header("Location:$redirect"); } ?>
<div class="container-fluid page-title">
			<div class="row blue-banner">
            	<div class="container main-container">
                	<div class="col-lg-12 col-md-12 col-sm-12">
                		<h3 class="white-heading"><?php echo $lang['email_verification']; ?></h3>
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
							<?php
					$hash = protect($_GET['hash']);
					$check_hash = $db->query("SELECT * FROM btc_users WHERE hash='$hash'");
					if($check_hash->num_rows>0) {
						$row = $check_hash->fetch_assoc();
						$update = $db->query("UPDATE btc_users SET hash='',status='1',email_verified='1' WHERE id='$row[id]'");
						echo success($lang['success_2']);
					} else {
						header("Location: $settings[url]");
					}
					?>
						</div>
					</div>
				</div>
			</div>
		</div>