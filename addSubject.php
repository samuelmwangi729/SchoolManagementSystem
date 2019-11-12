<?php
session_start();
require_once('Database.php');
if(isset($_SESSION['role'])){
	$Msg="";
	include('head.php');
	if(isset($_POST['sub'])){
		//handle the button event
		$subjectName=$_POST['subjectName'];
		$subjectCode=$_POST['subjectCode'];
		$catName=$_POST['cat'];
		$subAbbr=$_POST['abbr'];
		//insert into the database
		$db=new Database();
	if(	$db->insertSubject($subjectName,$subjectCode,$catName,$subAbbr)){
		//if true
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Subject Added</strong>
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Subject Not Added</strong>
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
	include('include/asidebar.php');
}else{
	echo "";
}
?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
						<form method="POST" action="addSubject.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Add A new Subject</strong></legend>
								<div class="row">
									<div class="col-sm-3">
										<label for="subjectName" class="label-control">Subject Name</label>
										<input type="text" name="subjectName" class="form-control" placeholder="Enter the subject Name" required/>
									</div>
									<div class="col-sm-3">
										<label for="subjectName" class="label-control">Subject Code</label>
										<input type="number" name="subjectCode" class="form-control" placeholder="Enter the Subject Code" required/>
									</div>
									<div class="col-sm-3">
										<label for="subjectName" class="label-control">Subject Abbreviation</label>
										<input type="text" name="abbr" class="form-control" placeholder="Enter the Subject Code" required/>
									</div>
									<div class="col-sm-3">
										<label for="Subject" class="label-control">Subject Category</label>&nbsp;<i class="fa fa-users" style="color:red"></i>
										<select name="cat" class="form-control">
											<?php $database=new Database();
											$results=$database->displayApproved('catsubject');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->catName;?></option>
										<?php }?>
										</select>
									</div>
									<div class="col-sm-3">
										<br>
										<button class="badge badge-success" name="sub" style="margin-top:10px">Add Subject</button>
									</div>
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
