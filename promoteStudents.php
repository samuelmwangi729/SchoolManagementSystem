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
	include('include/tsidebar.php');
}else{
	echo "";
}
if(isset($_POST['sub'])){
  $from=$_POST['from'];
  $to=$_POST['to'];
  $db=new Database();
  $status=$db->promote($to,$from);
	if($status){
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Success!!! Class Promoted</strong>
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Class Could Not be Promoted</strong>
		</div>";
	}
}

?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<span style="font-size:20px"><span class="text-primary">Promote Students</span></span>
					<div class="container">
					<form method="POST" action="promoteStudents.php" enctype="multipart/form-data">
						<?php echo $Msg;?>
						<div class="row">
							<div class="col-sm-6">
								<label for="From" class="label-control">Class To Promote </label>&nbsp;<i class="fa fa-list" style="color:red"></i>
								<select name="from" class="form-control">
									<option>--SELECT CLASS--</option>
									<?php $database=new Database();
									$results=$database->displayTable('classes');
									foreach ($results as $key) {
									?>
									<option><?php echo $key->form;?></option>
								<?php }?>
								</select>
							</div>
							<div class="col-sm-6">
								<label for="Subject" class="label-control">New Class To Promote To</label>&nbsp;<i class="fa fa-users" style="color:red"></i>
								<select name="to" class="form-control">
									<option>--SELECT CLASS--</option>
									<?php $database=new Database();
									$results=$database->displayTable('classes');
									foreach ($results as $key) {
									?>
									<option><?php echo $key->form;?></option>
								<?php }?>
                <option>Class of <?php echo date("Y");?></option>
								</select>
							</div>
						</div>
						<button class="badge badge-primary" name="sub" type="submit" style="margin-top:20px">Promote Classes</button>
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
