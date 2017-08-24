<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $settings['title']; ?></title>
	<meta name="description" content="<?php echo $settings['description']; ?>" />
	<meta name="keywords" content="<?php echo $settings['keywords']; ?>" />
	<meta name="author" content="www.exchangesoftware.info">
    <link rel="icon" href="<?php echo $settings['url']; ?>assets/images/favicon.png">
    <!-- Bootstrap -->
    <link href="<?php echo $settings['url']; ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!--Custom template CSS-->
     <link href="<?php echo $settings['url']; ?>assets/css/style.css" rel="stylesheet">
     <!--Custom template CSS Responsive-->
     <link href="<?php echo $settings['url']; ?>assets/webcss/site-responsive.css" rel="stylesheet">
       <!--Animated CSS -->
     <link href="<?php echo $settings['url']; ?>assets/webcss/animate.css" rel="stylesheet">
     <!--Owsome Fonts -->
     <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/font-awesome/css/font-awesome.min.css">
	 <!--<link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/webcss/custom_fonts.css">-->
     <!-- Important Owl stylesheet -->
    <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/owlslider/owl-carousel/owl.carousel.css">
     
    <!-- Default template -->
    <link rel="stylesheet" href="<?php echo $settings['url']; ?>assets/owlslider/owl-carousel/owl.template.css">
<?php if($lang['lang_type'] == "rtl") { ?>
	<link href="<?php echo $settings['url']; ?>assets/css/bootstrap-flipped.min.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?php echo $settings['url']; ?>assets/css/bootstrap-rtl.min.css" rel="stylesheet" type="text/css" media="all" />
	<?php } ?>
	<script type="text/javascript" src="<?php echo $settings['url']; ?>assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo $settings['url']; ?>assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo $settings['url']; ?>assets/js/bootstrap-notify.min.js"></script>
	<script type="text/javascript" src="<?php echo $settings['url']; ?>assets/js/jquery.playSound.js"></script>
	<script type="text/javascript" src="<?php echo $settings['url']; ?>assets/js/functions.js"></script>
	<script type="text/javascript" src="<?php echo $settings['url']; ?>assets/js/uploader.min.js"></script>
	<?php
	if(checkSession()) {
		?>
		<script type="text/javascript">
			function check_n() { btc_check_notifications('<?php echo $_SESSION['btc_uid']; ?>'); }
			setInterval(check_n,3000);
		</script>
		<?php
	}
	?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
    <body class="joblist style2  style3 title-image">
   	<!-- Header Image Or May be Slider-->
		<div id="header" class="container-fluid pages">
              <div class="row">
             <!-- Header Image Or May be Slider-->
                <div class="top_header">
                    <nav class="navbar navbar-fixed-top">
               			 
                         <div class="container">
                             <div class="logo">
                                <a href="<?php echo $settings['url']; ?>"><img src="<?php echo $settings['url']; ?>assets/images/logo2.png" alt="logo"/></a>
                             </div>
                             <div class="logins">
                    				<a href="<?php echo $settings['url']; ?>post-ad" class="post_job"><span class="label job-type partytime"><?php echo $lang['post_ad']; ?></span></a> 
                                   <?php
									if(checkSession()) { ?>
									<a href="<?php echo $settings['url']; ?>logout" class="login"><i class="fa fa-sign-out"></i></a>
									<a href="<?php echo $settings['url']; ?>account/wallet" class="login"><i class="fa fa-user"></i></a>
									<?php } else { ?>
									<a href="<?php echo $settings['url']; ?>login" class="login"><i class="fa fa-user"></i></a>
									<?php } ?>
                    		</div>
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                          </button>
                    </div>
                    
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                          <ul class="nav navbar-nav">
                            
                            <li><a href="<?php echo $settings['url']; ?>buy-bitcoins"><?php echo $lang['buy_bitcoins']; ?></a></li>
							<lI><a href="<?php echo $settings['url']; ?>sell-bitcoins"><?php echo $lang['sell_bitcoins']; ?></a></li>
							<lI><a href="<?php echo $settings['url']; ?>contact"><?php echo $lang['contact']; ?></a></li>
                           
							<?php if(checkSession()) { ?>
							 <li class="mobile-menu"><a href="<?php echo $settings['url']; ?>account/wallet"><?php echo $lang['menu_wallet']; ?></a></li>
                           <li class="mobile-menu"><a href="<?php echo $settings['url']; ?>logout"><?php echo $lang['menu_logout']; ?></a></li>
							<?php } else { ?>
							 <li class="mobile-menu"><a href="<?php echo $settings['url']; ?>post-ad"><?php echo $lang['post_ad']; ?></a></li>
                            <li class="mobile-menu"><a href="<?php echo $settings['url']; ?>login"><?php echo $lang['login']; ?> / <?php echo $lang['register']; ?></a></li>
                            <?php } ?>
						  </ul>
                     
                    </div><!-- navbar-collapse -->
                    
                    
					
                    </div>
					
                    <!-- container-fluid -->
                    </nav>
					
                 </div>
                 
                
            </div>
       	</div>
	<!-- Header Image Or May be Slider-->