<?php
//session_start();
require_once('config.php');
 //error_reporting(0);?>
<!DOCTYPE html>
<head>
	<link rel = "icon" type = "image/png" href ="assets/images/logo.png">
</head>
<header class="navbar navbar-default navbar-static-top" style="font-size:12px">
					<!-- start: NAVBAR HEADER -->
					<div class="navbar-header">
						<!-- <i class="fa fa-graduation-cap" style="color:red;font-size:50px;"></i> -->
						<a href="#" class="sidebar-mobile-toggler pull-left hidden-md hidden-lg" class="btn btn-navbar sidebar-toggle" data-toggle-class="app-slide-off" data-toggle-target="#app" data-toggle-click-outside="#sidebar">
							<i class="ti-align-justify"></i>
						</a>
						<a href="#" class="sidebar-toggler pull-right visible-md visible-lg" data-toggle-class="app-sidebar-closed" data-toggle-target="#app">
							<i class="ti-align-justify"></i>
						</a>
						<a class="pull-right menu-toggler visible-xs-block" id="menu-toggler" data-toggle="collapse" href=".navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<i class="ti-view-grid"></i>
						</a>
					</div>
					<!-- end: NAVBAR HEADER -->
					<!-- start: NAVBAR COLLAPSE -->
					<div class="navbar-collapse collapse">
						<ul class="nav navbar-right">
							<!-- start: MESSAGES DROPDOWN -->
							<?php
							$database=new Database();
							$results=$database->displayTable('settings');
							foreach ($results as $key) {
								$status="";
							?><li>
				     	<h6 style="color:red;line-height:50px;padding-right:90px"><img src="<?php echo "assets/images/".$key->Image;?>" width="70px" height="70px" style="border-radius:35px;float:left"></h6>
							</li>
							<li>
									<span style="line-height:70px;padding-left:00px;"><i class="fa fa-university" style="color:blue"></i>&nbsp;<?php echo $key->sName;?></span>
							</li>
							<li>
									<span style="line-height:70px;padding-left:50px;"><i class="fas fa-phone-alt" style="color:blue"></i>&nbsp;<?php echo $key->Phone;?></span>
							</li>
							<li>
									<span style="line-height:70px;padding-left:50px;"><i class="fas fa-dove" style="color:blue"></i>&nbsp;<?php echo "P.O.Box ".$key->pBox." ".$key->pCode." ".$key->pCity.", Kenya";?></span>
							</li>
								<?php } ?>
							<li class="dropdown current-user" style="padding-left:0px;line-height:70px">
								<a href class="dropdown-toggle" data-toggle="dropdown">
									<?php
									echo $_SESSION['role'];?>
									<i class="ti-angle-down"></i></i></span>
								</a>
								<ul class="dropdown-menu dropdown-dark">


									<li>
										<a href="changePassword.php">
											<i class="fa fa-cog"></i>Profile Settings
										</a>
									</li>
									<li>
										<a href="logout.php">
											<i class="fa fa-sign-out"></i>Log Out
										</a>
									</li>
								</ul>
							</li>
							<!-- end: USER OPTIONS DROPDOWN -->
						</ul>
						<!-- start: MENU TOGGLER FOR MOBILE DEVICES -->
						<div class="close-handle visible-xs-block menu-toggler" data-toggle="collapse" href=".navbar-collapse">
							<div class="arrow-left"></div>
							<div class="arrow-right"></div>
						</div>
						<!-- end: MENU TOGGLER FOR MOBILE DEVICES -->
					</div>


					<!-- end: NAVBAR COLLAPSE -->
				</header>
