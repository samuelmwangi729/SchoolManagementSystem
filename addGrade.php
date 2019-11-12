<?php
session_start();
require_once('Database.php');
if(isset($_SESSION['role'])){
	$Msg="";
	include('head.php');
	if(isset($_POST['sub'])){
		//get the exam name
		$subCat=$_POST['cat'];
		$Min=$_POST['min'];
		$Max=$_POST['max'];
		$Notation=mb_strtoupper($_POST['not']);
		//insert into the database
		$db=new Database();
		$db->query("INSERT INTO grades(subCat,Min,Max,Notation) VALUES(:subCat,:min,:max,:notation)");
		$db->bind(':subCat',$subCat);
		$db->bind(':min',$Min);
		$db->bind(':max',$Max);
		$db->bind(':notation',$Notation);
	if(	$db->execute()){
		//if true
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Grading Rule Successfully Added</strong>!!!Waiting Approval
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Grading Rule Not Be Added!!! An error Occurred. Try Again</strong>
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
						<form method="POST" action="addGrade.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Add A Grading Rule</strong></legend>
								<div class="row">
									<div class="col-sm-3">
										<label for="voteHead" class="label-control">Subject category</label>
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
										<label for="term" class="label-control">Minimun Marks</label>
										<input type="number" name="min" class="form-control" placeholder="Eg. 01" maxlength="2"/>
									</div>
									<div class="col-sm-3">
										<label for="term" class="label-control">Maximum Marks</label>
										<input type="number" name="max" class="form-control" placeholder="Eg. 19" maxlength="2"/>
									</div>
									<div class="col-sm-3">
										<label for="term" class="label-control">Grade Notation</label>
										<input type="text" name="not" class="form-control" placeholder="Eg. E" maxlength="2"/>
									</div>
									<br>
									<button class="badge badge-success fa fa-plus-circle" name="sub" style="margin-top:10px;margin-left:18px;">&nbsp;Add Grading Rule </button>
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
