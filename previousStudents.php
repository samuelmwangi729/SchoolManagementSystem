<?php
session_start();
require_once('Database.php');
$_SESSION['class']="Class of ".date("Y");
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
	$_SESSION['class']=$_POST['year'];
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
							$db->query("UPDATE student SET status=:status WHERE class=:id");
							$db->bind(':status',0);
							$db->bind(':id',$_SESSION['class']);
							$status=$db->execute();
							if($status){
								echo "<div class='alert alert-success 'id='alert'>
									<strong>Student Approved!!!</strong>
								</div>";
							}
						}
						if(isset($_GET['Deactivate'])){
							$id=$_GET['Deactivate'];
							$db=new Database();
							$db->query("UPDATE student SET status=:status WHERE class=:id");
							$db->bind(':status',1);
							$db->bind(':id',$_SESSION['class']);
							$status=$db->execute();
							if($status){
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Student Suspended!!</strong>
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
						<form method="POST" action="previousStudents.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Please select the Exam To view Results</strong></legend>
								<div class="row">
									<div class="col-sm-4">
										<label for="Subject" class="label-control">Year</label>&nbsp;<i class="fa fa-list" style="color:red"></i>
										<select name="year" class="form-control">
											<option><?php echo "Class of 2026"?></option>
											<option><?php echo "Class of 2025"?></option>
											<option><?php echo "Class of 2024"?></option>
											<option><?php echo "Class of 2023"?></option>
											<option><?php echo "Class of 2022"?></option>
											<option><?php echo "Class of 2021"?></option>
											<option><?php echo "Class of 2020"?></option>
											<option><?php echo "Class of 2019"?></option>
										</select>
									</div>
									<div class="col-sm-4">
										<br>
										<button class="badge badge-success fa fa-upload" style="margin-top:10px;" name="sub">&nbsp;&nbsp;Select Year</button>
									</div>
								</div>
							</fieldset>
						</form>
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
    								<td>Balance</td>
    							</tr>
    						</thead>
    						<tbody>
                  <?php
                  $database=new Database();
                  $database->query("SELECT * FROM student  WHERE class=:class");
                  $database->bind(':class',$_SESSION['class']);
                  $results=$database->resultSet();
                  $count=$database->rowCount();
									foreach ($results as $key) {
										$status="";
									?>
                  <tr>
                    <?php if($count==0){?>
                      echo "";
                    <?php }else{?>
                      <td><img src="<?php echo "Student/".$key->photo;?>" width="30px" height="30px" style="border-radius:25px"></td>
                      <td><?php echo $key->names;?></td>
                      <td><?php echo $key->regNo;?></td>
                      <td><?php echo $key->class;?></td>
                      <td><?php echo $key->stream;?></td>
                      <td><?php echo $key->parent;?></td>
                      <td><?php echo $key->Birthday;?></td>
                      <td><?php echo $key->gender;?></td>
                      <td><?php echo $key->dorm;?></td>
                      <td><?php echo $key->balance;?></td>
                      <?php }?>
                  </tr>
								<?php }?>
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
