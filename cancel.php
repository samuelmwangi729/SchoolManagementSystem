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
}

?>
			<div class="app-content">

						<?php include('include/header.php');?>
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
            Manage Exam Results
						<?php
						if(isset($_GET['Activate'])){
							$id=$_GET['Activate'];
							$db=new Database();
							$db->query("UPDATE examresults SET status=:status WHERE id=:id");
							$db->bind(':status',0);
							$db->bind(':id',$id);
							$status=$db->execute();
							if($status){
								echo "<div class='alert alert-success 'id='alert'>
									<strong>Exam Results Approved!!!</strong>
								</div>";
							}
						}
						if(isset($_GET['Deactivate'])){
							$id=$_GET['Deactivate'];
							$db=new Database();
							$db->query("UPDATE examresults SET status=:status WHERE id=:id");
							$db->bind(':status',1);
							$db->bind(':id',$id);
							$status=$db->execute();
							if($status){
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Exam Results Cancelled!!</strong>
								</div>";
							}else{
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Unknown Error Occurred!!</strong>
								</div>";
							}
						}
						if(isset($_GET['Delete'])){
							$id=$_GET['Delete'];
							$db=new Database();
							$delete=$db->delete('examresults',$id);
							if($delete){
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Exam Results deleted!!</strong>
								</div>";
							}
						}
						?>
            <div class="table table-responsive">
    					<table class="table table-striped table-codensed table-hover table-bordered">
    						<thead class="text-center">
    							<tr>
										<td>S/N</td>
										<td>Names</td>
    								<td>Year</td>
    								<td>Exam</td>
    								<td>Subject</td>
    								<td>Marks</td>
    								<td>Grade</td>
    								<td>Status</td>
										<td colspan="3">Actions</td>
    							</tr>
    						</thead>
    						<tbody>
									<?php
									$database=new Database();
									$results=$database->displayTable('examresults');
									foreach ($results as $key) {
										$status="";
									?>
									<tr>
											<td><?php echo $key->studentReg;?></td>
											<td><?php
											$db=new Database();
											$names=$db->getName($key->studentReg);
											echo $names;
											?></td>
											<td><?php echo $key->Year." Term ".$key->term?></td>
											<td><?php echo $key->exam;?></td>
											<td><?php echo $key->subject;?></td>
											<td><?php echo $key->marks;?></td>
										<td><?php
										$category=$db->getCategory($key->subject);
										$Grade=$db->getGrade($category,$key->marks);
										echo $Grade;
										?></td>
										<td><?php
										if($key->status==1){
											echo "<button class='badge badge-danger'>Cancelled</button>";
										}else{
												echo "<button class='badge badge-success'>Approved</button>";
										}
										?></td>
										<td><?php
										if($key->status==1){
											echo "<a href='cancel.php?Activate={$key->id}' class='badge badge-success'><i class='fa fa-check'>&nbsp;Approve</i></a>";
										}else{
												echo "<a href='cancel.php?Deactivate={$key->id}' class='badge badge-danger'><i class='fa fa-times'>&nbsp;Cancel</i></a>";
										}
										?></td>
										<td><?php 	echo "<a href='editResults.php?Edit={$key->id}' class='badge badge-primary'><i class='fa fa-edit'>&nbsp;Edit</i></a>";?></td>
										<td><?php 	echo "<a href='cancel.php?Delete={$key->id}' class='badge badge-danger'><i class='fa fa-trash'>&nbsp;Delete</i></a>";?></td>
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
