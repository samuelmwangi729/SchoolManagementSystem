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
            View Subjects
						<?php
						if(isset($_GET['Activate'])){
							$id=$_GET['Activate'];
							$db=new Database();
							$status=$db->activate('subject','status',$id);
							if($status){
								echo "<div class='alert alert-success'id='alert'>
									<strong>Subject Approved!!</strong>
								</div>";
							}
						}
						if(isset($_GET['Deactivate'])){
							$id=$_GET['Deactivate'];
							$db=new Database();
							$status=$db->deactivate('subject','status',$id);
							if($status){
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Subject Rejected!!</strong>
								</div>";
							}else{
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Error!!</strong>
								</div>";
							}
						}
						if(isset($_GET['Delete'])){
							$id=$_GET['Delete'];
							$db=new Database();
							$delete=$db->delete('subject',$id);
							if($delete){
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Subject deleted!!</strong>
								</div>";
							}else{
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Subject Not Deleted!!</strong>
								</div>";
							}
						}
						?>
            <div class="table table-responsive">
    					<table class="table table-striped table-condensed table-hover table-bordered">
    						<thead class="text-center">
    							<tr>
    								<td>Subject Name</td>
    								<td>Subject Code</td>
    								<td>Statuses</td>
										<td colspan="3">Action</td>
    							</tr>
    						</thead>
    						<tbody>
									<?php
									$database=new Database();
									$results=$database->displayTable('subject');
									foreach ($results as $key) {
										$status="";
									?>
									<tr>
										<td><?php echo $key->subjectName;?></td>
										<td><?php echo $key->subjectCode;?></td>
										<td><?php
										if($key->status==1){
											$status=1;
											echo "<span class='badge badge-success'>Approved</span>";
										}else{
											$status=0;
												echo "<span class='badge badge-danger'>Pending...</span>";
										}
										?></td>
										<td><?php
										if($status==1){
											echo "<a href='viewSubjects.php?Deactivate={$key->id}' class='badge badge-warning'><i class='fa fa-times'>&nbsp;Reject</i></a>";
										}else{
											echo "<a href='viewSubjects.php?Activate={$key->id}' class='badge badge-success'><i class='fa fa-check'>&nbsp;Approve</i></a>";
										}
										?></td>
										<td><?php 	echo "<a href='viewSubjects.php?Edit={$key->id}' class='badge badge-primary' id='Edit'><i class='fa fa-edit'>&nbsp;Edit</i></a>";?></td>
										<td><?php 	echo "<a href='viewSubjects.php?Delete={$key->id}' class='badge badge-danger'><i class='fa fa-times-circle'>&nbsp;Delete</i></a>";?></td>
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
				<div class="modal" tabindex="-1" id="edit">
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
