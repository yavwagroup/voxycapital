
					<?php
					$prefix = protect($_GET['prefix']);
						$query = $db->query("SELECT * FROM btc_pages WHERE prefix='$prefix'");
						if($query->num_rows>0) {
							$row = $query->fetch_assoc();
							?>
							<!--header section -->
    	<div class="container-fluid page-title">
			<div class="row blue-banner">
            	<div class="container main-container">
                	<div class="col-lg-12 col-md-12 col-sm-12">
                		<h3 class="white-heading"><?php echo $row['title']; ?></h3>
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
							<?php echo $row['content']; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
							<?php
						} else {
							header("Location: $settings[url]");
						}
					?>
