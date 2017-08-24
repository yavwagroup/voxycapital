<!DOCTYPE html>
<head>
  <meta charset="utf-8">
  <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
  <title><?php echo $settings['name']; ?> - Administrator Panel</title>
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="viewport" content="width=device-width">        
  <link rel="stylesheet" href="assets/css/templatemo_main.css">
</head>
<body>
  <div class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        <div class="logo"><h1><?php echo $settings['name']; ?> - Admin Panel</h1></div>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>   
    </div>
    <div class="template-page-wrapper">
      <div class="navbar-collapse collapse templatemo-sidebar">
        <ul class="templatemo-sidebar-menu">
          <li><a href="./"><i class="fa fa-dashboard"></i> Dashboard</a></li>
		  <li><a href="./?a=advertisements"><i class="fa fa-globe"></i> Advertisements</a></li>
		  <li><a href="./?a=trades"><i class="fa fa-exchange"></i> Trades</a></li>
		  <li><a href="./?a=reports"><i class="fa fa-comment-o"></i> Reports</a></li>
		  <li><a href="./?a=transactions"><i class="fa fa-credit-card"></i> Transactions</a></li>
		  <li><a href="./?a=api_keys"><i class="fa fa-database"></i> Block.io API Keys</a></li>
		  <li><a href="./?a=users"><i class="fa fa-users"></i> Users</a></li>
		  <li><a href="./?a=pages"><i class="fa fa-folder-o"></i> Pages</a></li>
		  <li><a href="./?a=faq"><i class="fa fa-question-circle"></i> FAQ</a></li>
		  <li><a href="./?a=settings"><i class="fa fa-cogs"></i> Web Settings</a></li>
          <li><a href="./?a=logout"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
      </div><!--/.navbar-collapse -->

      <div class="templatemo-content-wrapper">
        <div class="templatemo-content">