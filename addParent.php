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
	include('include/asidebar.php');
}else{
	echo "";
}
if(isset($_POST['sub'])){
	$names=strip_tags($_POST['names']);
	$email=strip_tags($_POST['email']);
	$gender=$_POST['gender'];
	$dob=$_POST['dob'];
	$empNumber=$_POST['empNumber'];
	$designation=$_POST['designation'];
	$department=$_POST['department'];
	$teachingSubject1=$_POST['teachingSubject1'];
	$teachingSubject2=$_POST['teachingSubject2'];
	$academicLevel=$_POST['academicLevel'];
	$salary=$_POST['pay'];
	$health=$_POST['health'];
	$tel=$_POST['tel'];
	$password=$_POST['password'];
	$empTerm=$_POST['empTerm'];
	$nationality=$_POST['nationality'];
	$previousEmployer=$_POST['previousEmployer'];
	$kra=$_POST['kra'];
	$idNumber=$_POST['idNumber'];
	//passport image upload
	$file=$_FILES['logo']['name'];
	$tmpName=$_FILES['logo']['tmp_name'];
	move_uploaded_file($tmpName, "teachers/$file");
	$db=new Database();
	$db->query("INSERT INTO teacher(names,email,gender,
	academicLevel,health,phone,nationality,passportName,empDate,role) VALUES(:names,:email,:gender,
	:academicLevel,:health,:phone,:nationality,:passportName,:empDate,:role)");
	$db->bind(':names',$names);
	$db->bind(':email',$email);
	$db->bind(':gender',$gender);
	$db->bind(':academicLevel',$academicLevel);
	$db->bind(':health',$health);
	$db->bind(':phone',$tel);
	$db->bind(':nationality',$nationality);
	$db->bind(':passportName',$file);
	$db->bind(':empDate',date("y-M-d"));
	$db->bind(':role','Parent');
	if($db->execute()){
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Success!!! Parent Added</strong>
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Parent Not Added</strong>
		</div>";
	}
}

?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<span style="font-size:20px"><span class="text-primary">Add a New Parent</span></span>
					<div class="container">
					<form method="POST" action="addParent.php" enctype="multipart/form-data">
						<?php echo $Msg;?>
						<div class="row">
							<div class="col-sm-3">
								<label for="names" class="control-label">Enter the names</label>&nbsp;<i class="fa fa-tags"style="color:red"></i>
								<input type="text" class="form-control" name="names" placeholder="Enter the names here" required maxlength="30"/>
							</div>
							<div class="col-sm-3">
								<label for="email" class="label-control">Email</label>&nbsp;<i class="fa fa-envelope"style="color:red"></i>
								<input type="email" class="form-control" name="email" placeholder="Enter the Email" required/>
							</div>
							<div class="col-sm-3">
								<label for="gender" class="label-control">Gender</label>&nbsp;<i class="fa fa-users"style="color:red"></i>
								<select name="gender" class="form-control">
									<option>--SELECT GENDER--</option>
									<option>Male</option>
									<option>Female</option>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="level" class="label-control">Academic Level</label>&nbsp;<i class="fa fa-graduation-cap" style="color:red"></i>
								<input type="text" class="form-control" name="academicLevel" placeholder="eg. Bachelors,Masters..." required/>
							</div>
							<div class="col-sm-3">
								<label for="" class="label-control">Disabled</label>&nbsp;<i class="fas fa-ribbon" style="color:red"></i>
								<select name="health" class="form-control">
									<option>--SELECT OPTION--</option>
									<option>Yes</option>
									<option>No</option>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="subject" class="label-control">Telephone</label>&nbsp;<i class="fa fa-phone" style="color:red"></i>
									<input type="number" class="form-control" name="tel" placeholder="eg.+254796844938" required/>
							</div>
							<div class="col-sm-3">
								<label for="" class="label-control">Nationality</label>&nbsp;<i class="fas fa-star" style="color:red"></i>
									<input type="text" class="form-control" name="nationality" placeholder="eg. Kenyan" required/>
							</div>
							<div class="col-sm-3">
								<label for="" class="label-control">Passport Photo</label>&nbsp;<i class="fas fa-image" style="color:red"></i>
								<input type="file" name="logo"/>
							</div>
						</div>
						<button class="btn btn-primary btn-raised" name="sub" type="submit" style="margin-top:20px">Add Parent</button>
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
