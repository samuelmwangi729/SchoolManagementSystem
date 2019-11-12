<?php
session_start();
// error_reporting(0);
$admin="";
$passwd="";
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
    $errorUsername="Invalid Username or Password";
  }
}
if(isset($_POST['adm'])){
  $admin="samuel mwangi";
  $passwd="P!@#four5sam";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin  | Dashboard</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=1, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themes/theme-4.css"/>
    <link rel = "icon" type = "image/png" href ="assets/images/logo.png">
	</head>
	<body>
    <div class="container" id="home">
    	<div class="row col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <form  method="POST" action="<?php $_SERVER['PHP_SELF'];?>">

      		<h1 class="text-success"> <i class="fa fa-door-open"></i> Login</h1>
      		<div class="form-group is-empty">
      			<i class="fa fa-user"></i> <label class="label-control text-primary" for="Username">Username</label><div style="color:red">	<?php echo $errorUsername;?></div>
      			<input type="text" class="form-control" name="username" required="true" minlength="5" placeholder="Enter Your Username" value="<?php echo $admin;?>">
      		</div>
      		<div class="form-group">

      			<i class="fa fa-lock" aria-hidden="true"></i> <label for="password" class="label-control text-primary">Password</label>
      			<input type="password" name="password" class="form-control" placeholder="Enter the Password here" required="true" minlength="8" value="<?php echo $passwd;?>">
      		</div>
      		<button type="submit" name="sub" class="btn btn-raised btn-primary btn-block"><i class="fa fa-sign-in-alt"></i>Login</button>
      	</form>
        <a href="#" id="forgot">forgot Password?</a>
        <form method="POST" action="<?php $_SERVER['PHP_SELF'];?>">
          <button type="submit" class="badge badge-success" name="adm">Admin Login</button>
        </form>
      </div>
      <div class="col-sm-6">
        <?php
          $db=new Database();
          $detail=$db->getSchool();
          foreach($detail as $key){
        ?>
        <h3 style="color:red;padding-left:30px"></h3>
        <hr style="width:500px">
        <div class="row" style="padding-left:20px;">
          <pre class="text-success text-center" style="font-size:17px;"><b><?php echo $key->sName ?></b>
            <pre><img src="<?php echo "assets/images/".$key->Image;?>" width="250px" height="250px" style="border-radius:25px"><b><?php echo "P.O.Box ".$key->pBox." ".$key->pCode." ".$key->pCity." Kenya" ?></b></pre>
          </pre>
        </div>
      </div>
    </div>
  <?php } ?>
    <!--Bootstrap Modals-->
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
