<?php
session_start();
$Msg="";
$Msg1="";
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
if(isset($_POST['sub'])){
	$studentId=strip_tags($_POST['reg']);
	$club=$_POST['club'];
	$db=new Database();
	$db->query("INSERT INTO clubsmembers(studentId,club) VALUES(:studentId,:club)");
	$db->bind(':studentId',$studentId);
	$db->bind(':club',$club);
	if($db->execute()){
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Success!!! Student Recorded</strong>
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Student   Not Added</strong>
		</div>";
	}
}
if(isset($_POST['subr'])){
	$studentId=strip_tags($_POST['reg']);
	$club=$_POST['club'];
	$db=new Database();
	$db->query("UPDATE clubsmembers SET status=0 WHERE studentId=:studentId AND club=:club");
	$db->bind(':studentId',$studentId);
	$db->bind(':club',$club);
	if($db->execute()){
		$Msg1="<div class='alert alert-success'id='alert'>
			<strong>Success!!! Student Membership Revoked</strong>
		</div>";
	}else{
		$Msg1="<div class='alert alert-danger'id='alert'>
			<strong>Student  Membership Not Revoked</strong>
		</div>";
	}
}

?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<span style="font-size:20px"><span class="text-primary">Club Memberships</span></span>
					<div class="container">
					<form method="POST" action="manageMembership.php" enctype="multipart/form-data">
						<?php echo $Msg;?>
						<div class="row">
							<div class="col-sm-6">
								<label for="Birthdate" class="label-control">Registration Number</label>&nbsp;<i class="fas fa-pen"style="color:red"></i>
                <select name="reg" class="form-control">
                  <option>--SELECT ADMISSION NUMBER--</option>
                  <?php $database=new Database();
                  $results=$database->displayTable('student');
                  foreach ($results as $key) {
                  ?>
                  <option><?php echo $key->regNo;?></option>
                <?php }?>
                </select>
							</div>
							<div class="col-sm-6">
								<label for="Club" class="label-control">Club</label>&nbsp;<i class="fa fa-list"style="color:red"></i>
								<!--[to be fetched form the database]-->
								<select name="club" class="form-control">
									<option>--SELECT CLUB--</option>
									<?php $database=new Database();
									$results=$database->displayApproved('club');
									foreach ($results as $key) {
									?>
									<option><?php echo $key->clubName;?></option>
								<?php }?>
								</select>
							</div>
						</div>
						<button class="badge badge-primary" name="sub" type="submit" style="margin-top:20px">Register Student</button>
					</form>
					<hr><br>
					<h1>Revoke Membership</h1><hr>
					<form method="POST" action="manageMembership.php" enctype="multipart/form-data">
						<?php echo $Msg1;?>
						<div class="row">
							<div class="col-sm-6">
								<label for="Birthdate" class="label-control">Registration Number</label>&nbsp;<i class="fas fa-pen"style="color:red"></i>
                <select name="reg" class="form-control">
                  <option>--SELECT ADMISSION NUMBER--</option>
                  <?php $database=new Database();
                  $results=$database->displayTable('student');
                  foreach ($results as $key) {
                  ?>
                  <option><?php echo $key->regNo;?></option>
                <?php }?>
                </select>
							</div>
							<div class="col-sm-6">
								<label for="Club" class="label-control">Club</label>&nbsp;<i class="fa fa-list"style="color:red"></i>
								<!--[to be fetched form the database]-->
								<select name="club" class="form-control">
									<option>--SELECT CLUB--</option>
									<?php $database=new Database();
									$results=$database->displayApproved('club');
									foreach ($results as $key) {
									?>
									<option><?php echo $key->clubName;?></option>
								<?php }?>
								</select>
							</div>
						</div>
						<button class="badge badge-primary" name="subr" type="submit" style="margin-top:20px">Revoke Membership</button>
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
