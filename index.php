<?php
session_start();
$Msg="Login";
include('Config.php');
require('Validate.php');
require_once('Database.php');
if(isset($_POST['sub'])){
  $username=$valid->sanitize($_POST['username']);
  $password= $valid->encrypt($_POST['password']);
  $database=new Database();
  $database->query("select * from users where username=:username AND password=:pass");
  $database->bind(':username',$username);
  $database->bind(':pass',$password);
  if($status=$database->single()){
    $_SESSION['role']=$valid->getRole($username);
    $_SESSION['username']=$username;
    if($status->status==0){
      header("location: restricted.php");
    }else{
      header("location: dashboard.php");
    }
  }else{
    $Msg="Invalid Username or Password";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>eSUnisol Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel = "icon" type = "image/png" href ="assets/images/eSUnisol.png">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	  <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
  <?php
    $db=new Database();
    $detail=$db->getSchool();
    foreach($detail as $key){
  ?>
	<div class="limiter">
		<div class="container-login100" style="background-image: url(<?php echo "assets/images/".$key->Image;?>);">
			<div class="wrap-login100">
				<form class="login100-form  validate-form" method="POST" action="<?php $_SERVER['PHP_SELF'];?>">
            <?php }?>
					<span class="login100-form-logo">
						<i class="fa fa-graduation-cap" style="color:red"></i>
					</span>
					<span class="login100-form-title p-b-34 p-t-27" style="color:red !important">
						<?php echo $Msg;?>
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" placeholder="Username" required minlength="5">
						<span class="focus-input100" data-placeholder="&#xf207;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password" minlength="8">
						<span class="focus-input100" data-placeholder="&#xf191;"></span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn" name="sub" type="submit">
							Login
						</button>
					</div>

          <div class="text-center p-t-90">
						<a class="txt1" href="#" id="forgot">
							Forgot Password?
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
  <!--Bootstrap modals-->
  <div class="modal" tabindex="-1" id="forgotPass">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <a href="#" class="close" data-toggle="modal" id="modalClose">&times;</a>
          <h2 class="modal-title text-danger text-center">Password Reset </h2>
        </div>
        <div class="modal-body">
          <span style="color:red;text-align:center">For Password Reset, Please Contact Your System Administrator</span>
        </div>
        <div class="modal-footer">
          &copy;<span style="color:red">Elite</span><span style="color:blue">SecurityConsultants</span> @<?php echo date('Y');?>
        </div>
      </div>
    </div>
  </div>

	<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
	  <script src="vendor/jquery/jquery.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
  <script>
    jQuery(document).ready(function() {
      $(document).on("click","#forgot",function(e){
        $("#forgotPass").show('fadeIn');
      });
      $(document).on('click','#modalClose',function(e){
        $('#forgotPass').hide('fadeOut');
      });
    });
  </script>

</body>
</html>
