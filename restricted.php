<?php
session_start();
include('Database.php');
if(isset($_SESSION['role'])){
	include('head.php');
?>
	<body>
		<div id="app">
<?php
//perform access management

?>
			<div class="app-content">

						<?php include('head.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<div class="row">

							<div class="col-sm-6"><i class="fas fa-user-injured" style="margin-top:190px;font-size:150px;color:gray"></i>&nbsp;&nbsp;<span style="color:red;font-size:20px">Dear <?php echo $_SESSION['role'];?>, You have been Suspended
								from using the System due to the violation of out terms and conditions. Please Contact
								Your Administrator For Assistance </span></div>
								<marquee><a href="index.php" class="badge badge-primary">HomePage</a></marquee>
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
