<?php
session_start();
require_once('Database.php');
if(isset($_SESSION['role'])){
	$id=$_GET['Edit'];
	$Msg="";
	include('head.php');
	if(isset($_POST['sub'])){
		//get the exam name]
		$id=$_POST['id'];
		$subCat=$_POST['cat'];
		$Min=$_POST['min'];
		$Max=$_POST['max'];
		$Notation=mb_strtoupper($_POST['not']);
		//insert into the database
		$db=new Database();
		$db->query("UPDATE  grades SET subCat=:subCat,Min=:min,Max=:max,Notation=:notation WHERE id=:id");
		$db->bind(':subCat',$subCat);
		$db->bind(':min',$Min);
		$db->bind(':max',$Max);
		$db->bind(':notation',$Notation);
		$db->bind(':id',$id);
	if(	$db->execute()){
		//if true
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Grading Rule Successfully Updated</strong>!!!Waiting Approval
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Grading Rule Not Be Updated!!! An error Occurred. Try Again</strong>
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
						<form method="POST" action="editRules.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Edit A Grading Rule <?php
								$db=new Database();
								$db->query("SELECT * FROM grades WHERE id=:id");
								$db->bind(':id',$id);
								if($result=$db->single()){
								?></strong></legend>
								<div class="row">
									<input type="hidden" name="id" value="<?php echo $id;?>"/>
									<div class="col-sm-3">
										<label for="voteHead" class="label-control">Subject category</label>
                    <select name="cat" class="form-control">
											<option><?php echo $result->subCat;?></option>
                      <?php $database=new Database();
                      $results=$database->displayApproved('catSubject');
                      foreach ($results as $key) {
                      ?>
                      <option><?php echo $key->catName;?></option>
                    <?php }?>
                    </select>
									</div>
									<div class="col-sm-3">
										<label for="term" class="label-control">Minimun Marks</label>
										<input type="number" name="min" class="form-control" value="<?php echo $result->Min;?>"/>
									</div>
									<div class="col-sm-3">
										<label for="term" class="label-control">Maximum Marks</label>
										<input type="number" name="max" class="form-control" value="<?php echo $result->Max;?>"/>
									</div>
									<div class="col-sm-3">
										<label for="term" class="label-control">Grade Notation</label>
										<input type="text" name="not" class="form-control" value="<?php echo $result->Notation;?>"/>
									</div>
									<br>
								<?php } ?>
									<button class="badge badge-success fa fa-check-circle" name="sub" style="margin-top:10px;margin-left:18px;">&nbsp;Update Grading Rule </button>
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
