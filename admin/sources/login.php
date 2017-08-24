<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
  <title><?php echo $settings['name']; ?> - Authorization</title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width">        
  <link rel="stylesheet" href="assets/css/templatemo_main.css">
<!-- 
Dashboard Template 
http://www.templatemo.com/preview/templatemo_415_dashboard
-->
</head>
<body>
  <div id="main-wrapper">
    <div class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        <div class="logo"><h1><?php echo $settings['name']; ?> - Authorization</h1></div>
      </div>   
    </div>
    <div class="template-page-wrapper">
      <form class="form-horizontal templatemo-signin-form" action="" method="POST">
		<div class="col-sm-12" style="padding:10px;">
			<div style="padding:20px;">
				<?php
				if(isset($_POST['btn_login'])) {
					$username = protect($_POST['username']);
					$password = protect($_POST['password']);
					$password = md5($password);
					$query = $db->query("SELECT * FROM btc_users WHERE username='$username' and password='$password'");
					if($query->num_rows>0) {
						$row = $query->fetch_assoc();
						if($row['status'] == "666") {
							$_SESSION['btc_admin_uid'] = $row['id'];
							header("Location: ./");
						} else {
							echo error("You have no privileges for that!");
						}
					} else {	
						echo error("Wrong username or password.");
					}
				}
				?>
			</div>
		</div>
        <div class="form-group">
          <div class="col-md-12">
            <label for="username" class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="username" id="username" placeholder="Username">
            </div>
          </div>              
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <label for="password" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <div class="col-sm-offset-2 col-sm-10">
              <input type="submit" name="btn_login" class="btn btn-default" value="Login">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>
</html>