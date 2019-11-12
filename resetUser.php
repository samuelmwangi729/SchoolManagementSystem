<?php
session_start();
require_once('Database.php');
$Msg="";
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
if(isset($_POST['sub'])){
	$username=$_POST['username'];
	$password=sha1($_POST['password']);
	$db=new Database();
	$db->query("UPDATE users SET password=:password WHERE username=:username");
	$db->bind(':password',$password);
	$db->bind(':username',$username);
	if($db->execute()){
		$Msg="<div class='alert alert-success'id='alert'>
			<strong><i class='fa fa-check-circle' style='color:blue;font-size:25px;lineheight:10px'></i>&nbsp;User Password Reset Successful!!</strong>
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong><i class='fa fa-times' style='color:blue;font-size:25px;lineheight:10px'></i>&nbsp;User Password Reset Error!!</strong>
		</div>";
	}
}
?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<form method="POST" action="resetUser.php">
							<?php echo $Msg;?>
							<fieldset>
							<h2 style="color:red">Reset Users Password</h2>
								<div class="row">
									<div class="col-sm-6">
										<label for="voteHead" class="label-control">Username</label>
										<select name="username" class="form-control">
											<?php $database=new Database();
											$results=$database->displayApproved('users');
											foreach ($results as $key) {
												if($key->role=="Administrator"){
													continue;
												}
											?>
											<option><?php echo $key->username;?></option>
										<?php }?>
										</select>
									</div>
									<div class="col-sm-3">
										<label for="level" class="label-control">Password</label>&nbsp;<i class="fa fa-lock" style="color:red"></i>
										<?php
										$str='abshkoeuh)(!@^&*$_+pl7';
										$empPassword=substr(str_shuffle($str), 8,16);
										?>
										<input type="text" class="form-control" name="password" value="<?php echo $empPassword;?>" required/>
									</div>
									<br>
									<button class="badge badge-success" name="sub" style="margin-top:5px;margin-left:18px;">Update Password</button>
								</div>
							</fieldset>
						</form>
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
