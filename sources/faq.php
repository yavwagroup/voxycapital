			<!--header section -->
    	<div class="container-fluid page-title">
			<div class="row blue-banner">
            	<div class="container main-container">
                	<div class="col-lg-12 col-md-12 col-sm-12">
                		<h3 class="white-heading"><?php echo $lang['faq']; ?></h3>
                    </div>
                </div>
            </div> 
        </div> 
  	 <!--header section -->
	 <div class="container-fluid white-bg">
        	<div class="row">
            	<div class="container">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="content">
						<div class="row">
					<?php
					$query = $db->query("SELECT * FROM btc_faq ORDER BY id");
					if($query->num_rows>0) {
						while($row = $query->fetch_assoc()) {
							?>
							<div class="col-md-12">
								<h4>Q? <?php echo $row['question']; ?></h4>
								<h5>A: <?php echo $row['answer']; ?></h4>
							</div>
							<?php
						}
					} else {
						echo 'No data for display.'; 
					}
					?>
					</div>
						</div>
					</div>
				</div>
			</div>
		</div>