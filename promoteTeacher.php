<?php
session_start();
require_once('Database.php');
if(isset($_SESSION['role'])){
	$Msg="";
	include('head.php');
	if(isset($_POST['sub'])){
		//handle the button event
		$empNumber=$_POST['empNumber'];
		$tableName="teacher";
		$field="designation";
		$designation=$_POST['designation'];
		//insert into the database
		$db=new Database();
	if(	$db->update($tableName,$field,$designation,$empNumber)){
		//if true
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Teacher Promoted</strong>
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Promotion Failed</strong>
		</div>";
	}
	}
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
	include('include/tsidebar.php');
}else{
	echo "";
}
?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
						<form method="POST" action="<?php $_SERVER['PHP_SELF'];?>">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Promote Teacher</strong></legend>
								<div class="row">
									<div class="col-sm-6">
										<label for="ClassName" class="label-control">Teacher Number</label>
										<select name="empNumber" class="form-control">
											<option>--TEACHER NUMBER--</option>
											<?php $database=new Database();
											$database->query('SELECT * FROM teacher WHERE role=:role');
											$database->bind(':role','teacher');
											$results=$database->resultSet();
											foreach ($results as $key) {
											?>
											<option><?php echo $key->empNumber;?></option>
										<?php }?>
										</select>
									</div>
									<div class="col-sm-6">
										<label for="ClassName" class="label-control">Teacher DESIGNATION</label>
										<select name="designation" class="form-control">
											<option>--SELECT DESIGNATION--</option>
											<?php $database=new Database();
											$results=$database->displayApproved('designation');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->designation;?></option>
										<?php }?>
										</select>
									</div>
									<br>
									<button class="badge badge-success" name="sub" style="margin-top:20px;margin-left:18px;">Promote Teacher</button>
								</div>
							</fieldset>
						</form>
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
				$(document).on('click','#alert',function(){
					alert('i have been clicked');
				});
			});
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
<?php }else{
	header("location: index.php");
}
