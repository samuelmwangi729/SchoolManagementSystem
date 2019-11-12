<?php
session_start();
$Msg="";
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
	$_SESSION['term']=$_POST['term'];
	$_SESSION['subject']=$_POST['subject'];
	$_SESSION['year']=$_POST['year'];
}

?>
			<div class="app-content">

						<?php include('include/header.php');?>
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
            View CAT Results
						<form method="POST" action="viewCats.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="font-size:30px;"><strong>Please select the CAT To view Results</strong></legend>
								<div class="row">
									<div class="col-sm-3">
										<label for="Subject" class="label-control">CAT TITLE</label>&nbsp;<i class="fa fa-list" style="color:red"></i>
										<select name="exam" class="form-control">
											<?php $database=new Database();
											$results=$database->displayApproved('cats');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->catName;?></option>
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
										<label for="Subject" class="label-control">Stream</label>&nbsp;<i class="fa fa-list" style="color:red"></i>
										<select name="stream" class="form-control">
											<?php $database=new Database();
											$results=$database->displayApproved('stream');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->streamName;?></option>
										<?php }?>
											<option><?php echo "All Stream";?></option>
										</select>
									</div>
									<div class="col-sm-3">
										<label for="Subject" class="label-control">Subject</label>&nbsp;<i class="fa fa-list" style="color:red"></i>
										<select name="subject" class="form-control">
											<?php $database=new Database();
											$results=$database->displayApproved('subject');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->subjectName;?></option>
										<?php }?>
											<option><?php echo "All Stream";?></option>
										</select>
									</div>
									<div class="col-sm-3">
										<label for="term" class="label-control">Select the Term</label>
										<select name="term" class="form-control">
											<option><?php echo " I";?></option>
											<option><?php echo " II";?></option>
											<option><?php echo " III";?></option>
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
										<br>
										<button class="badge badge-success fa fa-upload" style="margin-top:10px;" name="sub">&nbsp;&nbsp;Select Details</button>
									</div>
								</div>
							</fieldset>
						</form>
						<a href="resultsCat.php" class="badge badge-primary mr-auto"><i class="fa fa-print">Print Cats</i></a>
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
    								<td>Status</td>
    							</tr>
    						</thead>
    						<tbody>
								<tr>
									<?php
									$database=new Database();
									if($_SESSION['exam']==""  || $_SESSION['class']=="" || $_SESSION['stream']==""){
										$database->query("SELECT * FROM catresults ORDER BY id ASC");
									}else{
										$database->query("SELECT * FROM catresults   WHERE exam=:exam  AND Class=:class AND Stream=:stream AND Year=:year AND subject=:subject AND term=:term  ORDER BY id ASC");
										$database->bind(':exam',$_SESSION['exam']);
										$database->bind(':class',$_SESSION['class']);
										$database->bind(':stream',$_SESSION['stream']);
										$database->bind(':subject',$_SESSION['subject']);
										$database->bind(':year',$_SESSION['year']);
										$database->bind(':term',$_SESSION['term']);
									}
								  $results=$database->resultSet();
									if($database->rowCount()==0){
										echo "<div class='alert alert-danger'id='alert'>
											<strong>No record Found!!</strong>
										</div>";
									}else{
									foreach ($results as $key) {
										$status="";
									?>
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
										if($key->status==0){
											echo "<button class='badge badge-danger'>Cancelled</button>";
										}else{
												echo "<button class='badge badge-success'>Approved</button>";
										}
										?></td>

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
