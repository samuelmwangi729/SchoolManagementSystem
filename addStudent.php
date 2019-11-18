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
	$gender=$_POST['gender'];
	$dob=$_POST['dob'];
	$reg=$_POST['reg'];
	$kcpe=$_POST['kcpe'];
	$parent=$_POST['parent'];
	$class=$_POST['class'];
	$stream=$_POST['stream'];
	$health=$_POST['health'];
	$dorm=$_POST['dorm'];
	//passport image upload
	$file=$_FILES['logo']['name'];
	if($file==""){
		$f="default.png";
	}else{
		$f=$file;
		$tmpName=$_FILES['logo']['tmp_name'];
		move_uploaded_file($tmpName, "Student/$f");
	}
	$db=new Database();
	$db->query("INSERT INTO student(names,parent,class,stream,regNo,KCPE,Birthday,Year,gender,dorm,photo,status) VALUES(:names,:parent,:class,:stream,:regNo,:kcpe,:Birthday,:Year,
		:gender,:dorm,:photo,:status)");
	$db->bind(':names',$names);
	$db->bind(':parent',$parent);
	$db->bind(':class',$class);
	$db->bind(':stream',$stream);
	$db->bind(':regNo',$reg);
	$db->bind(':kcpe',$kcpe);
	$db->bind(':Birthday',$dob);
	$db->bind(':Year',date('Y'));
	$db->bind(':gender',$gender);
	$db->bind(':dorm',$dorm);
	$db->bind(':photo',$f);
	$db->bind(':status',1);
	if($db->execute()){
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Success!!! Student Added</strong>
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Student Added</strong>
		</div>";
	}
	//get the current term
	$db->query("SELECT currentSession FROM currentsession");
	$db->execute();
	$term=$db->fetchColumn();
	//invoice the student
	$nextTerm=$db->getNextTerm();
	if($term == $nextTerm){
		$results=$db->displaynTFees($class,$term);
	}else{
		$results=$db->displayFees($class,$term);
	}
  $total=0;
  foreach ($results as $key) {
    $total=$total+$key->amount;
  }
  echo $total;
  $db->query("UPDATE student SET fees=:fees WHERE class=:class and regNo=:regNo");
  $db->bind(':fees',$total);
  $db->bind(':class',$class);
	$db->bind(':regNo',$reg);
	$db->execute();
}

?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<span style="font-size:20px"><span class="text-primary">Add a New Student</span></span>
					<div class="container">
					<form method="POST" action="addStudent.php" enctype="multipart/form-data">
						<?php echo $Msg;?>
						<div class="row">
							<div class="col-sm-3">
								<label for="names" class="control-label">Enter the names</label>&nbsp;<i class="fa fa-tags"style="color:red"></i>
								<input type="text" class="form-control" name="names" placeholder="Enter the names here" required maxlength="30"/>
							</div>
							<div class="col-sm-3">
								<label for="gender" class="label-control">Gender</label>&nbsp;<i class="fa fa-users"style="color:red"></i>
								<select name="gender" class="form-control">
									<option>--SELECT GENDER--</option>
									<option>M</option>
									<option>F</option>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="Birthdate" class="label-control">Birth Date</label>&nbsp;<i class="fas fa-baby"style="color:red"></i>
								<input type="date" class="form-control" name="dob" required/>
							</div>
							<div class="col-sm-3">
								<label for="Birthdate" class="label-control">Registration Number</label>&nbsp;<i class="fas fa-pen"style="color:red"></i>
								<input type="text" class="form-control" name="reg" required value="<?php
								$database=new Database();
								$database->query("SELECT * FROM student");
								$database->execute();
								$tot=$database->rowCount();
								// echo "000".$tot+1;
								$database->query("SELECT endAdm FROM endadm");
								$database->execute();
								echo $database->fetchColumn()+$tot;
								 ?>" />
							</div>
							<div class="col-sm-3">
								<label for="Employee Number" class="label-control">Kcpe Marks</label>&nbsp;<i class="fas fa-tags"style="color:red"></i>
								<input type="text" class="form-control" name="kcpe" required/>
							</div>
							<div class="col-sm-3">
								<label for="Designation" class="label-control">Parent</label>&nbsp;<i class="fa fa-list"style="color:red"></i>
								<!--[to be fetched form the database]-->
								<select name="parent" class="form-control">
									<option>--SELECT PARENT--</option>
									<?php $database=new Database();
									$results=$database->displayParent('teacher');
									foreach ($results as $key) {
									?>
									<option><?php echo $key->names;?></option>
								<?php }?>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="Department" class="label-control">Class</label>&nbsp;<i class="fa fa-bank"style="color:red"></i>
								<select name="class" class="form-control">
									<option>--SELECT CLASSES--</option>
									<?php $database=new Database();
									$results=$database->displayTable('classes');
									foreach ($results as $key) {
									?>
									<option><?php echo $key->form;?></option>
								<?php }?>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="Subject" class="label-control">Stream</label>&nbsp;<i class="fa fa-list" style="color:red"></i>
								<select name="stream" class="form-control">
									<option>--SELECT STREAM--</option>
									<?php $database=new Database();
									$results=$database->displayTable('stream');
									foreach ($results as $key) {
									?>
									<option><?php echo $key->streamName;?></option>
								<?php }?>
								</select>
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
								<label for="Subject" class="label-control">Dormitory</label>&nbsp;<i class="fa fa-building" style="color:red"></i>
								<select name="dorm" class="form-control">
									<option>--SELECT DORMITORY--</option>
									<option>--N/A--</option>
									<?php $database=new Database();
									$results=$database->displayTable('dorm');
									foreach ($results as $key) {
									?>
									<option><?php echo $key->dormName;?></option>
								<?php }?>
								</select>
							</div>
							<div class="col-sm-3">
								<label for="Subject" class="label-control">Clubs</label>&nbsp;<i class="fa fa-users" style="color:red"></i>
								<select name="club" class="form-control">
									<option>--SELECT CLUB--</option>
									<option>--DECIDE LATER--</option>
									<?php $database=new Database();
									$results=$database->displayApproved('club');
									foreach ($results as $key) {
									?>
									<option><?php echo $key->clubName;?></option>
								<?php }?>
								</select>
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
						<button class="btn btn-primary btn-raised" name="sub" type="submit" style="margin-top:20px">Add Student</button>
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
