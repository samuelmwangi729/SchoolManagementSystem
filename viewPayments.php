<?php
session_start();
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
						<div class="table table-responsive">
							<table class="table table-striped table-codensed table-hover table-bordered">
								View Payments
								<thead class="text-center">
									<tr>
										<td>Admission Number</td>
										<td>Amount</td>
										<td>Term</td>
										<td>Mode</td>
										<td>Year</td>
										<td>Action</td>
									</tr>
								</thead>
								<tbody>
									<?php
									$database=new Database();
									$results=$database->displayTable(payments);
									foreach ($results as $key) {
										$status="";
									?>
									<tr>
										<td><?php echo $key->studentReg;?></td>
										<td><?php echo $key->Amount;?></td>
										<td><?php echo $key->term;?></td>
										<td><?php echo $key->mode;?></td>
										<td><?php echo $key->Year;?></td>
											<td><?php 	echo "<a href='generateReceipts.php?Generate={$key->id}' class='badge badge-success'><i class='fa fa-file-pdf'>&nbsp;Generate Receipt</i></a>";?></td>
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
