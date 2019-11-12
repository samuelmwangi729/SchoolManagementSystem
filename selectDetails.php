<?php
session_start();
require_once('Database.php');
$_SESSION['exam']="";
$_SESSION['student']="";
$_SESSION['class']="";
$_SESSION['stream']="";
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
if(isset($_POST['sub'])){
	$_SESSION['exam']=$_POST['exam'];
	$_SESSION['student']=$_POST['student'];
	$_SESSION['class']=$_POST['class'];
	$_SESSION['stream']=$_POST['stream'];
	$_SESSION['year']=$_POST['year'];
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
							$db->query("UPDATE examResults SET status=:status WHERE id=:id");
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
							$db->query("UPDATE examResults SET status=:status WHERE id=:id");
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
							$delete=$db->delete('examResults',$id);
							if($delete){
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Exam Results deleted!!</strong>
								</div>";
							}
						}
						?>
						<form method="POST" action="printReports.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Please select the Details to Print Report Forms </strong></legend>
								<div class="row">
									<div class="col-sm-3">
										<label for="Subject" class="label-control">Exam</label>&nbsp;<i class="fa fa-list" style="color:red"></i>
										<select name="exam" class="form-control">
											<?php $database=new Database();
											$results=$database->displayApproved('examinations');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->examTitle;?></option>
										<?php }?>
										</select>
									</div>
									<div class="col-sm-3">
										<label for="Subject" class="label-control">Class</label>&nbsp;<i class="fa fa-list" style="color:red"></i>
										<select name="class" class="form-control">
											<?php $database=new Database();
											$results=$database->displayApproved('classes');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->form;?></option>
										<?php }?>
										</select>
									</div>
									<div class="col-sm-3">
										<label for="Subject" class="label-control">Year</label>&nbsp;<i class="fa fa-list" style="color:red"></i>
										<select name="year" class="form-control">
											<option><?php echo "2023"?></option>
											<option><?php echo "2022"?></option>
											<option><?php echo "2021"?></option>
											<option><?php echo "2020"?></option>
											<option><?php echo "2019"?></option>
										</select>
									</div>
									<div class="col-sm-3">
										<label for="Subject" class="label-control">Term</label>&nbsp;<i class="fa fa-list" style="color:red"></i>
										<select name="term" class="form-control">
											<option><?php echo "I"?></option>
											<option><?php echo "II"?></option>
											<option><?php echo "III"?></option>
										</select>
									</div>
									<div class="col-sm-3">
										<br>
										<button class="badge badge-success fa fa-upload" style="margin-top:10px;" name="sub">&nbsp;&nbsp;Select Details</button>
									</div>
								</div>
							</fieldset>
						</form>
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
