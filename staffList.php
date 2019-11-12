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
            View Staff
            <div class="table table-responsive">
    					<table class="table table-striped table-codensed table-hover table-bordered">
    						<thead class="text-center">
    							<tr>
										<td>Passport</td>
    								<td>Names</td>
    								<td>Employee Number</td>
    								<td>Phone</td>
    								<td>Employment Type</td>
    								<td>Nationality</td>
    								<td>Status</td>
										<td colspan="3">Action</td>
    							</tr>
    						</thead>
    						<tbody>
									<?php
									$database=new Database();
									$results=$database->displayEmployee('teacher','Librarian');
									foreach ($results as $key) {
										$status="";
									?>
									<tr>
											<td><img src="<?php echo "teachers/".$key->passportName;?>" width="30px" height="30px" style="border-radius:25px"></td>
											<td><?php echo $key->names;?></td>
											<td><?php echo $key->empNumber;?></td>
											<td><?php echo $key->phone;?></td>
											<td><?php echo $key->empType;?></td>
											<td><?php echo $key->nationality;?></td>
										<td><?php
										if($key->status==1){
											$status=1;
											echo "<span style='color:green;'>Active</span>";
										}else{
											$status=0;
												echo "<span style='color:red;'>Suspended</span>";
										}
										?></td>
										<td><?php
										if($status==1){
											echo "<a href='staffList.php?Deactivate={$key->id}' class='badge badge-danger'><i class='fa fa-times'>&nbsp;Suspend</i></a>";
										}else{
											echo "<a href='staffList.php?Activate={$key->id}' class='badge badge-success'><i class='fa fa-check'>&nbsp;Reinstate</i></a>";
										}
										?></td>
										<td><?php 	echo "<a href='staffList.php?Delete={$key->id}' class='badge badge-info'><i class='fas fa-id-card'>&nbsp;Generate IdCard</i></a>";?></td>
									</tr>
								<?php }?>
    						 </tbody>
    					 </table>
    				</div>
						<!-- start: PAGE TITLE -->
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
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
