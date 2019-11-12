<?php
session_start();
$Msg="";
include('Database.php');
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
	$name=$_POST['sname'];
	$password=$_POST['password'];
	$cpassword=$_POST['cpassword'];
	if($password!=$cpassword){
		$Msg="<div class='alert alert-danger'id='alert'>
				<strong>Error!!! Passwords Dont Match</strong>
			</div>";
	}else{
		$db=new Database();
		$db->query("UPDATE users SET password=:password WHERE username=:username");
		$db->bind(':password',sha1($password));
		$db->bind(':username',$_SESSION['username']);
		$stat=$db->execute();
		if($stat){
			$Msg="<div class='alert alert-success'id='alert'>
					<strong>Success!!! Password Updated</strong>
				</div>";
		}
	}
}
?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
            <?php echo $_SESSION['username'];?>
						<form method="POST" action="changePassword.php">
              <fieldset>
                <legend style="border:0px;font-size:30px;"><strong>Please Fill In the Above</strong></legend>
								<?php echo $Msg;?>
                <div class="row">
                    <input type="hidden" class="form-control" name="sname" value="<?php echo $_SESSION['username'];?>"/>
                  <div class="col-sm-6">
                    <label for="Subject" class="label-control"></label>&nbsp;New Password<i class="fas fa-lock" style="color:red"></i>
                    <input type="password" class="form-control" required  name="password" minlength="8" />
                  </div>
                  <div class="col-sm-6">
                    <label for="Subject" class="label-control"></label>&nbsp;Confirm New Password<i class="fas fa-lock" style="color:red"></i>
                    <input type="password" class="form-control" required  name="cpassword" minlength="8" />
                  </div>
                  <div class="col-sm-3">
                    <br>
                    <button class="badge badge-success fa fa-upload" style="margin-top:10px;" name="sub" <?php echo $disabled;?> >&nbsp;&nbsp;Update Password</button>
                  </div>
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
