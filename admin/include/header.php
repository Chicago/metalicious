<?php
//debug
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

include_once dirname(__FILE__) . '/../../classes/user.php';

//get user_info if they exist
if (isset($_COOKIE['user_id'])) {
    $user_info = User::get_user_info($_COOKIE['user_id']);
}

//get permissions if they exist
if (isset($_COOKIE['users_user_types'])) {
    $users_user_types = unserialize(base64_decode($_COOKIE['users_user_types']));
}

//if the page is in the admin section
if (substr($_SERVER['PHP_SELF'], 0, 7) == '/admin/') {
    //if user is logged in
    if (!isset($users_user_types)) {
        header("Location: /");
    } else {
        //permissions test
        if (!in_array('Administrator', $users_user_types)) {
            header("Location: /");
        }
    }
}

include dirname(__FILE__) . '/widgets.php';
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
    
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-responsive.css" rel="stylesheet">
    
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="../assets/css/font-awesome.css" rel="stylesheet">
    
    <link href="../assets/css/admin.css" rel="stylesheet"> 
    <link href="../assets/css/admin-responsive.css" rel="stylesheet"> 
    
    <link href="../assets/css/dashboard.css" rel="stylesheet"> 
    

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


        <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
        <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
        <script type="text/javascript">
            $(document).ajaxStart(function() {
                $('#ajax_loader').fadeIn('slow');
            });

            $(document).ajaxStop(function() {
                $('#ajax_loader').fadeOut('slow');
            });
        </script>
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-8633108-15']);
            _gaq.push(['_trackPageview']);
    
            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
  </head>

<body>
	
<div class="navbar navbar-fixed-top">
	
	<div class="navbar-inner">
		
		<div class="container">
			
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>
			
			<a class="brand" href="../">
				<img src="../images/metalicious_banner.png" />				</a>		
			
			<div class="nav-collapse">
                            <ul class="nav pull-right">
                                <li class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="icon-user"></i> 
                                    <?php echo $user_info['First_Name'] . " " . $user_info['Last_Name']; ?>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php
                                    if (isset($users_user_types)) {
                                        //permissions test
                                        if (in_array('Administrator', $users_user_types)) {
                                            ?>
                                            <li>
                                                <a href="./">Admin</a>
                                            </li>
                                            <li>
                                                <a href="./import.php">Import</a>
                                            </li>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <li class="divider"></li>
                                    <li><a href="../login.php?action=logout">Logout</a></li>
                                </ul>
                                </li>
                            </ul>
                                <!--
				<ul class="nav pull-right">
					<li class="dropdown">
						
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon-cog"></i>
							Settings
							<b class="caret"></b>
						</a>
						
						<ul class="dropdown-menu">
							<li><a href="javascript:;">Account Settings</a></li>
							<li><a href="javascript:;">Privacy Settings</a></li>
							<li class="divider"></li>
							<li><a href="javascript:;">Help</a></li>
						</ul>
						
					</li>
			
					<li class="dropdown">	
						<ul class="dropdown-menu">
							<li><a href="javascript:;">My Profile</a></li>
							<li><a href="javascript:;">My Groups</a></li>
							<li class="divider"></li>
							<li><a href="javascript:;">Logout</a></li>
						</ul>
						
					</li>
				</ul>
                                -->
				<form class="navbar-search pull-right" method="post" action="../search.php">
                                    <input type="text" class="search-query" placeholder="Search" id="search_criteria" name="search_criteria" />
                                </form>
				
			</div><!--/.nav-collapse -->	
	
		</div> <!-- /container -->
		
	</div> <!-- /navbar-inner -->
	
</div> <!-- /navbar -->
    



    
<div class="subnavbar">

	<div class="subnavbar-inner">
	
		<div class="container">

			<ul class="mainnav">
			
				<li class="active">
					<a href="../">
						<i class="icon-home"></i>
						<span>Home</span>
					</a>	    				
				</li>
				
				<li>					
					<a href="./add_variable.php">
						<i class="icon-lemon"></i>
						<span>Add Variable</span>
					</a>	  				
				</li>
				
				<li>
					<a href="./add_table.php">
						<i class="icon-th-large"></i>
						<span>Add Table</span>
					</a>    				
				</li>
				
				<li>					
					<a href="./add_database.html">
						<i class="icon-lemon"></i>
						<span>Add Database</span>
					</a>  									
				</li>

				<li>					
					<a href="./user_management.php">
						<i class="icon-user"></i>
						<span>User Management</span>
					</a>  									
				</li>
			
			</ul>

		</div> <!-- /container -->
	
	</div> <!-- /subnavbar-inner -->

</div> <!-- /subnavbar -->

<div id="content">
	
	<div class="container">
