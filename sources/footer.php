<!--Footer Area-->
   		<div class="container-fluid footer">
        	<div class="row">
            <div class="container main-container-home">
            	<div class="col-md-3">
					<h3><?php echo $lang['pages']; ?></h3>
					 <ul class="list-unstyled">
						<li><a href="<?php echo $settings['url']; ?>faq"><?php echo $lang['faq']; ?></a></li>
						<li><a href="<?php echo $settings['url']; ?>page/terms-of-services"><?php echo $lang['terms_of_services']; ?></a></li>
						<li><a href="<?php echo $settings['url']; ?>page/privacy-policy"><?php echo $lang['privacy_policy']; ?></a></li>
					</ul>
				</div>
				<div class="col-md-4">
					<h3><?php echo $lang['languages']; ?></h3>
					 <ul class="list-unstyled">
						<?php echo getLanguage($settings['url'],null,1); ?>
					</ul>
				</div>
				<div class="col-md-5">
					<h3><?php echo $lang['follow_us']; ?></h3>
					Twitter or Facebook code here.
				</div>
			</div>
            	
            </div>
            </div>
        </div>
    <!--Footer Area--> 
    <!--Last Footer Area---->
    	<div class="container-fluid footer last-footer ">
        	<div class="row">
            <div class="container main-container">
            	<div class="col-lg-9 col-md-3 col-sm-9 col-xs-6" >
                	<p class="copyright">Copyright © 2017. Developed by <a href="http://www.exchangesoftware.info">www.exchangesoftware.info</a></p>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                	<ul class="list-group">
                    	<li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus-square"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
                
            </div>
            </div>
        </div>
    <!--Last Footer Area----> 
	<input type="hidden" id="url" value= "<?php echo $settings['url']; ?>">
<!-- Scripts
================================================== -->
    <script type="text/javascript" src="<?php echo $settings['url']; ?>assets/js/select2.min.js"></script>
    <!-- Html Editor -->
    <script src="<?php echo $settings['url']; ?>assets/tinymce/tinymce.min.js"></script>
	<!--  parallax.js-1.4.2  -->
    <script type="text/javascript" src="<?php echo $settings['url']; ?>assets/parallax.js-1.4.2/parallax.js"></script>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo $settings['url']; ?>assets/js/bootstrap.min.js"></script>
   	<!-- Include js plugin -->
    <script type="text/javascript" src="<?php echo $settings['url']; ?>assets/owlslider/owl-carousel/owl.carousel.js"></script>
    <script type="text/javascript" src="<?php echo $settings['url']; ?>assets/js/waypoints.min.js"></script> 
  	<script type="text/javascript" src="<?php echo $settings['url']; ?>assets/counter/jquery.counterup.min.js"></script> 
    <!--Site JS-->
     <script src="<?php echo $settings['url']; ?>assets/js/webjs.js"></script>

  <!-- Scripts
================================================== -->
	</body>
</html>