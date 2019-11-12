<?php
session_start();
$Msg="";
require_once('Database.php');
if(isset($_SESSION['role'])){
	include('head.php');
?>
	<body>
		<div id="app">
<?php
//perform access management
if($_SESSION['role']=="Administrator"){
	include('include/sidebar.php');
}else if($_SESSION['role']=="teacher"){
	include('include/tsidebar.php');
}else if($_SESSION['role']=="Accountant"){
	include('include/asidebar.php');
}else{
	echo "";
}
?><?php
if(isset($_GET['Activate'])){
	$id=$_GET['Activate'];
	$db=new Database();
	$status=$db->activate('users','status',$id);
	if($status){
		$Msg="<div class='alert alert-success'id='alert'>
			<strong><i class='fa fa-check-circle' style='color:blue;font-size:25px;lineheight:10px'></i>&nbsp;User Reinstated!!</strong>
		</div>";
	}
}
if(isset($_GET['Deactivate'])){
	$id=$_GET['Deactivate'];
	$db=new Database();
	$status=$db->deactivate('users','status',$id);
	if($status){
		$Msg="<div class='alert alert-danger 'id='alert'>
			<strong><i class='fa fa-times'></i>&nbsp;User suspended!!</strong>
		</div>";
	}
}
?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<div class="table table-responsive">
							<table class="table table-striped table-codensed table-hover table-bordered">
								View Users
								<thead class="text-center">
									<?php echo $Msg;?>
									<tr>
										<td>Name</td>
										<td>Role</td>
										<td>status</td>
										<td>Action</td>
									</tr>
								</thead>
								<tbody>
									<?php
									$database=new Database();
									$results=$database->displayTable(users);
									foreach ($results as $key) {
										$status="";
										if($key->role=="Administrator"){
											continue;
										}
									?>
									<tr class="text-center">
										<td><?php echo $key->username;?></td>
										<td><?php echo $key->role;?></td>
										<?php if($key->status==0){?>
											<td><button class="badge badge-danger">Suspended</button></td>
										<?php }else{?>
												<td><button class="badge badge-primary">Active</button></td>
										<?php }?>
										<?php if($key->status==0){?>
											<td><?php 	echo "<a href='viewUsers.php?Activate={$key->id}' class='badge badge-success'><i class='fa fa-check-circle'>&nbsp;Activate</i></a>";?></td>
										<?php }else{?>
												<td><?php 	echo "<a href='viewUsers.php?Deactivate={$key->id}' class='badge badge-danger'><i class='fa fa-trash'>&nbsp;Suspend</i></a>";?></td>
										<?php }?>
									</tr>
								<?php }?>
								 </tbody>
							 </table>
						</div>
					</div>
				</div>
			</div>
			<!-- start: FOOTER -->
	<?php include('include/footer.php');?>
		</div>
		<!-- start: MAIN JAVASCRIPTS -->
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<script src="assets/js/main.js"></script>

		<script>
			jQuery(document).ready(function() {
				Main.init();
				FormElements.init();
			});
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
<?php }else{
	header("location: index.php");
}
