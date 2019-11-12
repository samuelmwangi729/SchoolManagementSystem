<?php
session_start();
require_once('Database.php');
if(isset($_SESSION['role'])){
	$Msg="";
	include('head.php');
	if(isset($_POST['sub'])){
		//get the exam name
		$eName=$_POST['etitle'];
		$term=$_POST['term'];
		$class=$_POST['class'];
		//insert into the database
		$db=new Database();
		$db->query("INSERT INTO examinations(examTitle,Term,Year,Class) VALUES(:examTitle,:term,:year,:class)");
		$db->bind(':examTitle',$eName);
		$db->bind(':term',$term);
		$db->bind(':year',date('Y'));
		$db->bind(':class',$class);
	if(	$db->execute()){
		//if true
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Examination Successfully Added</strong>!!!Waiting Approval
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Exam Could Not Be Added!!! An error Occurred. Try Again</strong>
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
						<form method="POST" action="addExam.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Add An Examination</strong></legend>
								<div class="row">
									<div class="col-sm-3">
										<label for="voteHead" class="label-control">Exam Title</label>
										<input type="text" class="form-control" name="etitle" placeholder="type the exam title" required />
									</div>
									<div class="col-sm-3">
										<label for="term" class="label-control">Examination Term</label>
										<input type="text" name="term" class="form-control" value="<?php $database=new Database();
										$database->query("SELECT currentSession FROM currentsession");
										$database->execute();
										echo $database->fetchColumn();
											?>" readonly/>
									</div>
									<div class="col-sm-3">
										<label for="Department" class="label-control">Class</label>&nbsp;<i class="fa fa-bank"style="color:red"></i>
										<select name="class" class="form-control">
											<option>--SELECT CLASSES--</option>
											<option>All Classes</option>
											<?php $database=new Database();
											$results=$database->displayTable('classes');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->form;?></option>
										<?php }?>
										</select>
									</div>
									<br>
									<button class="badge badge-success fa fa-plus-circle" name="sub" style="margin-top:10px;margin-left:18px;">&nbsp;Add Examination </button>
								</div>
							</fieldset>
						</form>
						<br>
				</div>
			</div>
			<!-- start: FOOTER -->
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
