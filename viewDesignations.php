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
            View Designation
						<?php
						if(isset($_GET['Activate'])){
							$id=$_GET['Activate'];
							$db=new Database();
							$status=$db->activate('designation','status',$id);
							if($status){
								echo "<div class='alert alert-success'id='alert'>
									<strong>Designation Approved!!</strong>
								</div>";
							}
						}
						if(isset($_GET['Deactivate'])){
							$id=$_GET['Deactivate'];
							$db=new Database();
							$status=$db->deactivate('designation','status',$id);
							if($status){
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Done!!!Designation Rejected!!</strong>
								</div>";
							}else{
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Designation not Rejected!!</strong>
								</div>";
							}
						}
						if(isset($_GET['Delete'])){
							$id=$_GET['Delete'];
							$db=new Database();
							$delete=$db->delete('designation',$id);
							if($delete){
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Designation deleted!!</strong>
								</div>";
							}else{
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Designation Not Deleted!!</strong>
								</div>";
							}
						}
						?>
            <div class="table table-responsive">
    					<table class="table table-striped table-codensed table-hover table-bordered">
    						<thead class="text-center">
    							<tr>
    								<td>Class</td>
    								<td>Statuses</td>
										<td colspan="3">Action</td>
    							</tr>
    						</thead>
    						<tbody>
									<?php
									$database=new Database();
									$results=$database->displayTable('designation');
									foreach ($results as $key) {
										$status="";
									?>
									<tr>
										<td><?php echo $key->designation;?></td>
										<td><?php
										if($key->status==1){
											$status=1;
											echo "<span style='color:green;'>Approved</span>";
										}else{
											$status=0;
												echo "<span style='color:red;'>Pending...</span>";
										}
										?></td>
										<td><?php
										if($status==1){
											echo "<a href='viewDesignations.php?Deactivate={$key->id}' class='badge badge-danger'><i class='fa fa-times'>&nbsp;Disapprove</i></a>";
										}else{
											echo "<a href='viewDesignations.php?Activate={$key->id}' class='badge badge-success'><i class='fa fa-check'>&nbsp;Approve</i></a>";
										}
										?></td>
										<td><?php 	echo "<a href='viewDesignations.php?Edit={$key->id}' class='badge badge-primary'><i class='fa fa-edit'>&nbsp;Edit</i></a>";?></td>
										<td><?php 	echo "<a href='viewDesignations.php?Delete={$key->id}' class='badge badge-danger'><i class='fa fa-times-circle'>&nbsp;Delete</i></a>";?></td>
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
