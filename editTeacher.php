<?php
session_start();
$Msg="";
require_once('Database.php');
$id=$_GET['Edit'];
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
	$init=$_POST['init'];
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
	$tId=$_POST['id'];
	$password=$_POST['password'];
	$empTerm=$_POST['empTerm'];
	$nationality=$_POST['nationality'];
	$previousEmployer=$_POST['previousEmployer'];
	$kra=$_POST['kra'];
	$idNumber=$_POST['idNumber'];
	//passport image upload
	$file=$_FILES['logo']['name'];
	if($file==""){
		$f="default.png";
	}else{
		$f=$file;
		$tmpName=$_FILES['logo']['tmp_name'];
		move_uploaded_file($tmpName, "teachers/$file");
	}
	$db=new Database();
	$db->query("UPDATE teacher SET names=:names,Initial=:init,email=:email,gender=:gender,bdate=:bdate,empNumber=:empNumber,designation=:designation,department=:department,major=:major,
    minor=:minor,academicLevel=:academicLevel,salary=:salary,health=:health,password=:password,empType=:empType,nationality=:nationality,previousEmployer=:previousEmployer,passportName=:passportName WHERE id=:id");
	$db->bind(':names',$names);
	$db->bind(':init',$init);
	$db->bind(':email',$email);
	$db->bind(':gender',$gender);
	$db->bind(':bdate',$dob);
	$db->bind(':empNumber',$empNumber);
	$db->bind(':designation',$designation);
	$db->bind(':department',$department);
	$db->bind(':major',$teachingSubject1);
	$db->bind(':minor',$teachingSubject2);
	$db->bind(':academicLevel',$academicLevel);
	$db->bind(':salary',$salary);
	$db->bind(':health',$health);
	$db->bind(':password',sha1($password));
	$db->bind(':empType',$empTerm);
	$db->bind(':nationality',$nationality);
	$db->bind(':previousEmployer',$previousEmployer);
	$db->bind(':passportName',$f);
  $db->bind(':id',$tId);
	if($db->execute()){
		echo "<script>window.open('viewTeacher.php','_self');</script>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Teacher Details Not Updated</strong>
		</div>";
	}
}

?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<span style="font-size:20px"><span class="text-primary">Edit Teacher Details</span></span>
					<div class="container">
            <?php
            $db=new Database();
            $db->query("select * from teacher where id=:id");
            $db->bind(':id',$id);
            if($results=$db->single()){
            ?>
            <div style="float:right">
              <img src="<?php echo "teachers/".$results->passportName;?>" width="150px" height="150px" style="border-radius:100px">
            </div>
					<form method="POST" action="editTeacher.php" enctype="multipart/form-data">
						<?php echo $Msg;?>
						<div class="row">
							<div class="col-sm-3">
                	<input type="hidden" class="form-control" name="id" value="<?php echo $results->id;?>"/>
								<label for="names" class="control-label">Enter the names</label>&nbsp;<i class="fa fa-tags"style="color:red"></i>
								<input type="text" class="form-control" name="names" value="<?php echo $results->names;?>" required maxlength="30"/>
							</div>
							<div class="col-sm-3">
                	<input type="hidden" class="form-control" name="id" value="<?php echo $results->id;?>"/>
								<label for="names" class="control-label">Enter the Initials</label>&nbsp;<i class="fa fa-tags"style="color:red"></i>
								<input type="text" class="form-control" name="init" value="<?php echo $results->Initial;?>" required maxlength="30"/>
							</div>
							<div class="col-sm-3">
								<label for="email" class="label-control">Email</label>&nbsp;<i class="fa fa-envelope"style="color:red"></i>
								<input type="email" class="form-control" name="email" value="<?php echo $results->email;?>" />
							</div>
							<div class="col-sm-3">
								<label for="gender" class="label-control">Gender</label>&nbsp;<i class="fa fa-users"style="color:red"></i>
								<select name="gender" class="form-control">
									<option><?php echo $results->gender;?></option>
									<option>Male</option>
									<option>Female</option>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="Employee Number" class="label-control">Employee Number/TSC Number</label>&nbsp;<i class="fas fa-tags"style="color:red"></i>
								<!--[generated by the system]-->
								<input type="text" class="form-control" name="empNumber" value="<?php echo $results->empNumber;?>" />
							</div>
							<div class="col-sm-3">
								<label for="Designation" class="label-control">Designation</label>&nbsp;<i class="fa fa-list"style="color:red"></i>
								<!--[to be fetched form the database]-->
								<select name="designation" class="form-control">
									<option><?php echo $results->designation;?></option>
									<?php $database=new Database();
									$resuls=$database->displayApproved('designation');
									foreach ($resuls as $key) {
									?>
									<option><?php echo $key->designation;?></option>
								<?php }?>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="Department" class="label-control">Department</label>&nbsp;<i class="fa fa-bank"style="color:red"></i>
								<select name="department" class="form-control">
									<option><?php echo $results->department;?></option>
									<?php $database=new Database();
									$resuls=$database->displayApproved('department');
									foreach ($resuls as $key) {
									?>
									<option><?php echo $key->department;?></option>
								<?php }?>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="Subject" class="label-control">Teaching Subject 1</label>&nbsp;<i class="fa fa-book" style="color:red"></i>
								<select name="teachingSubject1" class="form-control">
										<option><?php echo $results->major;?></option>
									<?php $database=new Database();
									$resuls=$database->displayApproved('subject');
									foreach ($resuls as $key) {
									?>
									<option><?php echo $key->subjectName;?></option>
								<?php }?>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="subject" class="label-control">Teaching Subject 2</label>&nbsp;<i class="fa fa-book" style="color:red"></i>
								<select name="teachingSubject2" class="form-control">
									<option><?php echo $results->minor;?></option>
									<?php $database=new Database();
									$resuls=$database->displayApproved('subject');
									foreach ($resuls as $key) {
									?>
									<option><?php echo $key->subjectName;?></option>
								<?php }?>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="level" class="label-control">Academic Level</label>&nbsp;<i class="fa fa-graduation-cap" style="color:red"></i>
								<input type="text" class="form-control" name="academicLevel" value="<?php echo $results->academicLevel;?>" />
							</div>
							<div class="col-sm-3">
								<label for="pay" class="label-control">Salary</label>&nbsp;<i class="fas fa-hand-holding-usd" style="color:red"></i>
								<input type="number" class="form-control" name="pay" value="<?php echo $results->salary;?>" />
							</div>
							<div class="col-sm-3">
								<label for="" class="label-control">Disabled</label>&nbsp;<i class="fas fa-ribbon" style="color:red"></i>
								<select name="health" class="form-control">
									<option><?php echo $results->health;?></option>
									<option>Yes</option>
									<option>No</option>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="level" class="label-control">Password</label>&nbsp;<i class="fa fa-graduation-cap" style="color:red"></i>
								<input type="password" class="form-control" name="password" value="*************" required/>
							</div>
							<div class="col-sm-3">
								<label for="pay" class="label-control">Terms of Employment</label>&nbsp;<i class="fas fa-question" style="color:red"></i>
								<select name="empTerm" class="form-control">
									<option><?php echo $results->empType;?></option>
									<option>Permanent</option>
									<option>Contractual</option>
									<option>Temporary</option>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="" class="label-control">Nationality</label>&nbsp;<i class="fas fa-star" style="color:red"></i>
									<input type="text" class="form-control" name="nationality" value="<?php echo $results->nationality;?>"/>
							</div>
							<div class="col-sm-3">
								<label for="" class="label-control">Previous Employer</label>&nbsp;<i class="fas fa-user" style="color:red"></i>
								<input type="text" class="form-control" name="previousEmployer" value="<?php echo $results->previousEmployer;?>" />
							</div>
							<!-- <div class="col-sm-3">
								<label for="" class="label-control">Passport Photo</label>&nbsp;<i class="fas fa-image" style="color:red"></i>
								<input type="file" name="logo"/>
							</div> -->
						</div>
          <?php
         }
          ?>
						<button class="btn btn-success btn-raised" name="sub" type="submit" style="margin-top:20px">Update Details</button>
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
