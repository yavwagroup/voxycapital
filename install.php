<?php
error_reporting(0);
ob_start();
session_start();
include("includes/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Install BitcoinsMarket v1.0</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
	<link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="assets/css/install.css" rel="stylesheet">
  </head>

  <body>

     <!-- Static navbar -->


	<div class="container"">
		<div class="row">
			<div class="col-lg-12 box-white rounded">
				    <div class="navbar navbar-default rounded-top" role="navigation">
					  <div class="container">
						<div class="navbar-header">
						  <a class="navbar-brand" href="./">BitcoinsMarket v1.0</a>
					    </div>
					  </div>
					</div>	
					<div class="row" style="padding-bottom:10px;">
						<div class="col-lg-12">
						<?php
						if(isset($_GET['unset_license'])) { session_unset(); session_destroy(); unset($_SESSION['license_key']); header("Location: ./install.php"); }
						if($_SESSION['license_key']) {
							if(isset($_POST['fc_install'])) {
								$mysql_host = protect($_POST['mysql_host']);
								$mysql_user = protect($_POST['mysql_user']);
								$mysql_pass = protect($_POST['mysql_pass']);
								$mysql_base = protect($_POST['mysql_base']);
								$title = protect($_POST['title']);
								$description = protect($_POST['description']);
								$keywords = protect($_POST['keywords']);
								$name = protect($_POST['name']);
								$url = protect($_POST['url']);
								$infoemail = protect($_POST['infoemail']);
								$supportemail = protect($_POST['supportemail']);
			$sell_comission = protect($_POST['sell_comission']);
			$buy_comission = protect($_POST['buy_comission']);
			$withdrawal_comission = protect($_POST['withdrawal_comission']);
			$api_key = protect($_POST['api_key']);
			$api_secret_pin = protect($_POST['api_secret_pin']);
			$api_address = protect($_POST['api_address']);
								$username = protect($_POST['username']);
								$email = protect($_POST['email']);
								$password = protect($_POST['password']);
								
								if(empty($mysql_host) or empty($mysql_user) or empty($mysql_pass) or empty($mysql_base) or empty($title) or empty($description) or empty($keywords) or empty($api_address) or empty($name) or empty($url) or empty($infoemail) or empty($supportemail) or empty($sell_comission) or empty($buy_comission) or empty($withdrawal_comission) or empty($api_key) or empty($api_secret_pin)) {
									echo error("All fields are required."); 
								} elseif(!isValidURL($url)) { 
									echo error("Please enter valid site url address.");
								} elseif(!isValidEmail($infoemail)) { 
									echo error("Please enter valid info email address.");
								} elseif(!isValidEmail($supportemail)) { 
									echo error("Please enter valid support email address.");
								} elseif(!is_numeric($buy_comission)) {
									echo error("Please enter buy comission with numbers.");
								} elseif(!is_numeric($sell_comission)) { 
									echo error("Please enter sell comission with numbers.");
								}  elseif(!is_numeric($withdrawal_comission)) { 
									echo error("Please enter withdrawal comission with numbers.");
								} else {
									$db = new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_base);
									if($db->connect_errno) {
										echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
									} else {
											$db->set_charset("utf8");
											$license_key = protect($_SESSION['license_key']);
											$domain = $_SERVER['SERVER_NAME'];
											$checkurl = 'http://license.bitcoinsmarket.info/?get_db_tables=1&license_key='.$license_key.'&domain='.$domain;
											$ch = curl_init();
										// Disable SSL verification
										curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
										// Will return the response, if false it print the response
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
										// Set the url
										curl_setopt($ch, CURLOPT_URL,$checkurl);
										// Execute
										$contents=curl_exec($ch);
										// Closing
										curl_close($ch);
										$json_a=json_decode($contents,true);

											foreach ($json_a as $key => $value){
												$string[$key] = $value;
											}
											
											if($string['status'] == "error") { die($string['message']); }
											$sql_contents = $string['message'];
											$sql_contents = explode(";", $sql_contents);

											foreach($sql_contents as $k=>$v) {
												$db->query($v);
											}
											$current .= '<?php
	';
											$current .= '$CONF = array();
	';
											$current .= '$CONF["host"] = "'.$mysql_host.'";
	';
											$current .= '$CONF["user"] = "'.$mysql_user.'";
	';
											$current .= '$CONF["pass"] = "'.$mysql_pass.'";
	';
											$current .= '$CONF["name"] = "'.$mysql_base.'";
	';
											$current .= '?>';
											
											file_put_contents("includes/config.php", $current);

											@unlink("install.php"); 
											$insert = $db->query("INSERT btc_settings (title) VALUES ('Installing...')");
											$update = $db->query("UPDATE btc_settings SET title='$title',description='$description',keywords='$keywords',name='$name',url='$url',infoemail='$infoemail',supportemail='$supportemail',sell_comission='$sell_comission',buy_comission='$buy_comission',withdrawal_comission='$withdrawal_comission'");
											$passwd = md5($password);
											$insert_admin = $db->query("INSERT btc_users (password,email,username,status) VALUES ('$passwd','$email','$username','666')");
											$insert_license = $db->query("INSERT btc_blockio_licenses (account,license,secret_pin,address,addresses,default_license) VALUES ('Default API','$api_key','$api_secret_pin','$api_address','0','1')");
											$install_success=1;
											$_SESSION['license_key'] = '';
										} 
								}
							}
							
							if($install_success !== 1) {
							?>
								<form action="" method="POST" role="form">
								<div class="row">
									<div class="col-md-12">
									<h3>MySQL Connection</h3>
									  <div class="form-group">
										<label>MySQL Host</label>
										<input type="text" class="form-control" name="mysql_host" value="<?php if(isset($_POST['mysql_host'])) { echo $_POST['mysql_host']; } ?>">
									  </div>
									  <div class="form-group">
										<label>MySQL Username</label>
										<input type="text" class="form-control" name="mysql_user" value="<?php if(isset($_POST['mysql_user'])) { echo $_POST['mysql_user']; } ?>">
									  </div>
									  <div class="form-group">
										<label>MySQL Password</label>
										<input type="password" class="form-control" name="mysql_pass" value="<?php if(isset($_POST['mysql_pass'])) { echo $_POST['mysql_pass']; } ?>">
									  </div>
									  <div class="form-group">
										<label>MySQL Database</label>
										<input type="text" class="form-control" name="mysql_base" value="<?php if(isset($_POST['mysql_base'])) { echo $_POST['mysql_base']; } ?>">
									  </div>
								</div>
								<div class="col-md-12">
									<h3>Web Settings</h3>
									  <div class="form-group">
											<label>Title</label>
											<input type="text" class="form-control" name="title" value="<?php if(isset($_POST['title'])) { echo $_POST['title']; } ?>">
										</div>
										<div class="form-group">
											<label>Description</label>
											<textarea class="form-control" name="description" rows="2"><?php if(isset($_POST['description'])) { echo $_POST['description']; } ?></textarea>
										</div>
										<div class="form-group">
											<label>Keywords</label>
											<textarea class="form-control" name="keywords" rows="2"><?php if(isset($_POST['keywords'])) { echo $_POST['keywords']; } ?></textarea>
										</div>
										<div class="form-group">
											<label>Site name</label>
											<input type="text" class="form-control" name="name" value="<?php if(isset($_POST['name'])) { echo $_POST['name']; } ?>">
										</div>
										<div class="form-group">
											<label>Site url address</label>
											<input type="text" class="form-control" name="url" value="<?php if(isset($_POST['url'])) { echo $_POST['url']; } ?>">
										</div>
										<div class="form-group">
											<label>Info email address</label>
											<input type="text" class="form-control" name="infoemail" value="<?php if(isset($_POST['infoemail'])) { echo $_POST['infoemail']; } ?>">
										</div>
										<div class="form-group">
											<label>Support email address</label>
											<input type="text" class="form-control" name="supportemail" value="<?php if(isset($_POST['supportemail'])) { echo $_POST['supportemail']; } ?>">
										</div>
										<div class="form-group">
											<label>Block.io API Key</label>
											<input type="text" class="form-control" name="api_key" value="<?php if(isset($_POST['api_key'])) { echo $_POST['api_key']; } ?>">
											<small>Go to <a href="https://block.io" target="_blank">Block.io</a> website and create account, then click on button "Show API Keys" and copy api key for Bitcoin.</small>
										</div>
										<div class="form-group">
											<label>Block.io Secret PIN</label>
											<input type="text" class="form-control" name="api_secret_pin" value="<?php if(isset($_POST['api_secret_pin'])) { echo $_POST['api_secret_pin']; } ?>">
											<small>Enter your Block.io account Secret PIN to allow API to work.</small>
										</div>
										<div class="form-group">
											<label>Block.io Bitcoin Address</label>
											<input type="text" class="form-control" name="api_address" value="<?php if(isset($_POST['api_address'])) { echo $_POST['api_address']; } ?>">
											<small>Enter your Block.io default bitcoin address. Need to be address from your created account to receive your comissions!</small>
										</div>
										<div class="form-group">
											<label>Comission when client buy Bitcoin from Trader</label>
											<div class="input-group">
												<input type="text" class="form-control" name="buy_comission" value="<?php if(isset($_POST['buy_comission'])) { echo $_POST['buy_comission']; } ?>">
												<span class="input-group-addon" id="basic-addon2">BTC</span>
											</div>
											<small>Trader will be charged with amount you enter in this field when client buy bitcoins from him/her, this comission automatically will be transfered in your Bitcoin address setuped in <a href="./?a=api_keys">Block.io API Keys</a>.</small>
										</div>
										<div class="form-group">
											<label>Comission when client sell Bitcoin to Trader</label>
											<div class="input-group">
												<input type="text" class="form-control" name="sell_comission" value="<?php if(isset($_POST['sell_comission'])) { echo $_POST['sell_comission']; } ?>">
												<span class="input-group-addon" id="basic-addon2">BTC</span>
											</div>
											<small>Client will be charged with the amount entered in this field when he decided to buy Bitcoin from a Trader. It will be added to the amount he wants to exchange, this comission automatically will be transfered in your Bitcoin address setuped in <a href="./?a=api_keys">Block.io API Keys</a>.</small>
										</div>
										<div class="form-group">
											<label>Comission when client withdrawal or send Bitcoins to other address</label>
											<div class="input-group">
												<input type="text" class="form-control" name="withdrawal_comission" value="<?php if(isset($_POST['withdrawal_comission'])) { echo $_POST['withdrawal_comission']; } ?>">
												<span class="input-group-addon" id="basic-addon2">BTC</span>
											</div>
											<small>This comission automatically will be transfered in your Bitcoin address setuped in <a href="./?a=api_keys">Block.io API Keys</a>.</small>
										</div>
										
							    </div>
								<div class="col-md-12">
									<h3>Create Admin Account</h3>
									  <div class="form-group">
										<label>Username</label>
										<input type="text" class="form-control" name="username" value="<?php if(isset($_POST['username'])) { echo $_POST['username']; } ?>">
									  </div>
									  <div class="form-group">
										<label>Email address</label>
										<input type="text" class="form-control" name="email" value="<?php if(isset($_POST['email'])) { echo $_POST['email']; } ?>">
									  </div>
									  <div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" name="password">
									  </div>
									</div>
								</div>
									<button type="submit" class="btn btn-primary btn-block" name="fc_install"><i class="fa fa-check-circle"></i> Install</button>
								</form>
							<?php 
							} else {
							?>
							<h3>Installation was successfully!</h3>
							<p>Your BitcoinsMarket v1.0 address: <a href="<?php echo $url; ?>"><?php echo $url; ?></a></p><br/>
							<p>Your BitcoinsMarket v1.0 admin panel address: <a href="<?php echo $url; ?>admin"><?php echo $url; ?>admin</a></p><br/>
							<p>Admin account: <?php echo $username; ?> / <?php echo protect($_POST['password']); ?></p><br/>
							<p>Note that not all system settings, please after login with admin account finish them from the admin menu</p>
							<?php
							}
						} else {
							if(isset($_POST['fc_verify'])) {
								$license_key = protect($_POST['license_key']);
								$domain = $_SERVER['SERVER_NAME'];
								$checkurl = 'http://license.bitcoinsmarket.info/?check=1&license_key='.$license_key.'&domain='.$domain;
								$ch = curl_init();
										// Disable SSL verification
										curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
										// Will return the response, if false it print the response
										curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
										// Set the url
										curl_setopt($ch, CURLOPT_URL,$checkurl);
										// Execute
										$contents=curl_exec($ch);
										// Closing
										curl_close($ch);
										$json_a=json_decode($contents,true);

								foreach ($json_a as $key => $value){
									$string[$key] = $value;
								}
								
								if($string['status'] == "success") {
									$_SESSION['license_key'] = $license_key;
									header("Location: ./install.php");
								} else {
									echo error($string['message']);
								}
							}
							?>	
								<form action="" method="POST">
										<div class="form-group">
										<label>License key</label>
										<input type="text" class="form-control" name="license_key">
									  </div>
									
									<button type="submit" class="btn btn-primary btn-block" name="fc_verify"><i class="fa fa-check-circle"></i> Verify license</button>
								</form>
							<?php
						}
						?>
						</div>
			</div>
		</div>
	</div>
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/bootstrap.js"></script>
	<script type="text/javascript" src="assets/js/source.js"></script>
    <script language="javascript" type="text/javascript" src="assets/uploader/js/arfaly-min.js" ></script>
	<script language="javascript" type="text/javascript" src="assets/uploader/js/custom.js" ></script>
  </body>
</html>
					