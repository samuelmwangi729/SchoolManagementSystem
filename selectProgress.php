studentProgress.php
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
?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
            <?php echo $Msg;?>
						<form method="POST" action="studentProgress.php">
              <fieldset>
                <legend style="border-bottom:1px solid red">
                  Student Progress Record
                </legend>
                <div class="row">
                  <div class="col-sm-6">
                    <label for="class" class="label-control fas fa-user-graduate" style="color:red">&nbsp;&nbsp;Select Student</label>
                    <input type='text' class='form-control input-md' name='student' placeholder='Enter the student Reg Number' required/>
                  </div>
                  <br>
                <div class="col-sm-6">
                  <button style="margin-top:5px;" class="btn btn-success fa fa-check-circle" type="submit" name="sub">&nbsp;&nbsp;Print Progress Report</button>
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
