<?php
session_start();
$rec="";
require_once('Database.php');
$_SESSION['query']="SELECT * FROM student";
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
            View Students
						<?php
						if(isset($_GET['Activate'])){
							$id=$_GET['Activate'];
							$db=new Database();
							$status=$db->activate('student','status',$id);
							if($status){
								echo "<div class='alert alert-success'id='alert'>
									<strong>Student Readmited!!</strong>
								</div>";
							}
						}
						if(isset($_GET['Deactivate'])){
							$id=$_GET['Deactivate'];
							$db=new Database();
							$status=$db->deactivate('student','status',$id);
							if($status){
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Student suspended!!</strong>
								</div>";
							}else{
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Student not Deactivated!!</strong>
								</div>";
							}
						}
						?>
						<div class="container">
							<div class="form-group">
								<form method="POST" action="viewStudent.php" class="form-inline" style="float:right">
									<input type="text" class="form-control" name="search" placeholder="Registration Number to Search" required/>
								  <button type="submit" class="btn btn-primary" name="sub"><i class="fa fa-search"></i></button>
								</form>
							</div>
						</div>
            <div class="table table-responsive">
    					<table class="table table-striped table-codensed table-hover table-bordered">
    						<thead class="text-center">
    							<tr>
										<td>Passport</td>
    								<td>Names</td>
    								<td>Reg Number</td>
    								<td>Class</td>
    								<td>Stream</td>
    								<td>Parent</td>
    								<td>Birthday</td>
    								<td>Gender</td>
    								<td>Dorm</td>
    								<td>Status</td>
										<td colspan="3">Action</td>
    							</tr>
    						</thead>
    						<tbody>
									<?php
									$database=new Database();
									if(isset($_POST['sub'])){
										$search=$_POST['search'];
										$database->query("SELECT * FROM student WHERE regNo=:regNo");
										$database->bind(':regNo',$search);
										$database->execute();
										$count=$database->rowCount();
										$results=$database->resultSet();
										if($count==0){
											echo "<div class='alert alert-danger'>
											<strong><i class='fa fa-times-circle'></i>No Records Found</strong>
											</div>";
										}
										foreach ($results as $key) {?>
											<tr>
												<td><img src="<?php echo "Student/".$img;?>" width="30px" height="30px" style="border-radius:25px"></td>
												<td><?php echo $key->names;?></td>
												<td><?php echo $key->regNo;?></td>
												<td><?php echo $key->class;?></td>
												<td><?php echo $key->stream;?></td>
												<td><?php echo $key->parent;?></td>
												<td><?php echo $key->Birthday;?></td>
												<td><?php echo $key->gender;?></td>
												<td><?php echo $key->dorm;?></td>
											<td><?php
											if($key->status==1){
												$status=1;
												echo "<span style='color:green;'>Active</span>";
											}else{
												$status=0;
													echo "<span style='color:red;'>Suspended/Transfered</span>";
											}
											?></td>
											<td><?php
											if($status==1){
												echo "<a href='viewStudent.php?Deactivate={$key->id}' class='badge badge-danger'><i class='fa fa-times'>&nbsp;Suspend</i></a>";
											}else{
												echo "<a href='viewStudent.php?Activate={$key->id}' class='badge badge-success'><i class='fa fa-check'>&nbsp;Readmit</i></a>";
											}
											?></td>
											<td><?php 	echo "<a href='editStudent.php?Edit={$key->id}' class='badge badge-primary'><i class='fa fa-edit'>&nbsp;Edit</i></a>";?></td>
											<td><?php 	echo "<a href='#' class='badge badge-info'><i class='fa fa-eye'>&nbsp;View</i></a>";?></td>
										</tr>
										<?php }
									}else{
									$database->query($_SESSION['query']);
									$results=$database->resultSet();
									foreach ($results as $key) {
										$status="";
									?>
									<tr><?php if($key->photo==""){
										$img="default.png";
									}else{
										$img=$key->photo;
									}?>
											<td><img src="<?php echo "Student/".$img;?>" width="30px" height="30px" style="border-radius:25px"></td>
											<td><?php echo $key->names;?></td>
											<td><?php echo $key->regNo;?></td>
											<td><?php echo $key->class;?></td>
											<td><?php echo $key->stream;?></td>
											<td><?php echo $key->parent;?></td>
											<td><?php echo $key->Birthday;?></td>
											<td><?php echo $key->gender;?></td>
											<td><?php echo $key->dorm;?></td>
										<td><?php
										if($key->status==1){
											$status=1;
											echo "<span style='color:green;'>Active</span>";
										}else{
											$status=0;
												echo "<span style='color:red;'>Suspended/Transfered</span>";
										}
										?></td>
										<td><?php
										if($status==1){
											echo "<a href='viewStudent.php?Deactivate={$key->id}' class='badge badge-danger'><i class='fa fa-times'>&nbsp;Suspend</i></a>";
										}else{
											echo "<a href='viewStudent.php?Activate={$key->id}' class='badge badge-success'><i class='fa fa-check'>&nbsp;Readmit</i></a>";
										}
										?></td>
										<td><?php 	echo "<a href='editStudent.php?Edit={$key->id}' class='badge badge-primary'><i class='fa fa-edit'>&nbsp;Edit</i></a>";?></td>
										<td><?php 	echo "<a href='#' class='badge badge-info'><i class='fa fa-eye'>&nbsp;View</i></a>";?></td>
									</tr>
								<?php }}?>
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
