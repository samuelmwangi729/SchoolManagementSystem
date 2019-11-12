<?php
$Msg="";
session_start();
require_once('Database.php');
$db=new Database();
$_SESSION['exam']="";
$_SESSION['year']=date('Y');
$_SESSION['term']=$db->getCurrentTerm();
$_SESSION['stream']="";
$status="";
if(isset($_SESSION['role'])){
	include('head.php');
?>
	<body>
		<div id="app">
<?php
//perform access management
if($_SESSION['role']=="Administrator"){
	include('include/sidebar.php');
}


?>
			<div class="app-content">

						<?php include('include/header.php');?>
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
            Exams Ranking
						<?php
						if(isset($_POST['upMean'])){
							$tot=$_POST['tot'];
							$stream=$_POST['stream'];
							$exam=$_POST['exam'];
							$db=new Database();
							$db->query("INSERT INTO classMeans(class,stream,term,year,exam,total) VALUES(:class,:stream,:term,:year,:exam,:total)");
							$db->bind(':class',$_SESSION['class']);
							$db->bind(':stream',$stream);
							$term=$_SESSION['term'];
							$db->bind(':term',$term);
							$db->bind(':year',$_SESSION['year']);
							$db->bind(':exam',$exam);
							$db->bind(':total',$tot);
							$status=$db->execute();
							if($status){
								echo "<div class='alert alert-success 'id='alert'>
									<strong>Class Means Updated!!!</strong>
								</div>";
							}
						}
						if(isset($_GET['Deactivate'])){
							$id=$_GET['Deactivate'];
							$db=new Database();
							$db->query("UPDATE examResults SET status=:status WHERE id=:id");
							$db->bind(':status',1);
							$db->bind(':id',$id);
							$status=$db->execute();
							if($status){
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Exam Results Cancelled!!</strong>
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
						<form method="POST" action="rank.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Select Details to Generate Class Mean</strong></legend>
								<div class="row">
									<div class="col-sm-3">
										<label for="Subject" class="label-control">Exam</label>&nbsp;<i class="fa fa-list" style="color:red"></i>
										<select name="exam" class="form-control">
											<?php $database=new Database();
											$results=$database->displayApproved('examinations');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->examTitle;?></option>
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
										</select>
									</div>
									<div class="col-sm-3">
										<label for="Subject" class="label-control">Term</label>&nbsp;<i class="fa fa-list" style="color:red"></i>
										<select name="term" class="form-control">
											<option><?php echo "I"?></option>
											<option><?php echo "II"?></option>
											<option><?php echo "III"?></option>
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
									<div class="col-sm-2">
										<br>
										<button class="badge badge-success fa fa-upload" style="margin-top:10px;" name="sub">&nbsp;&nbsp;Select Details</button>
									</div>
								</div>
							</fieldset>
						</form>

            <?php
						if(isset($_POST['sub'])){
						$_SESSION['exam']=$_POST['exam'];
						$_SESSION['class']=$_POST['class'];
						$_SESSION['stream']=$_POST['stream'];
						$_SESSION['term']=$_POST['term'];
						$_SESSION['year']=$_POST['year'];
						//get the grades of each and every subject then divide them with every entry
						$db->query('SELECT * FROM examResults WHERE Class=:class AND term=:term AND Year=:year AND Stream=:stream  AND exam=:exam');
						$db->bind(':class',$_SESSION['class']);
						$term=$_SESSION['term'];
						$db->bind(':term',$term);
						$db->bind(':year',$_SESSION['year']);
						$db->bind(':stream',$_SESSION['stream']);
						$db->bind(':exam',$_SESSION['exam']);
						$db->execute();
						$gradetotals=$db->resultSet();
						$gradet=0;
						$count=0;
						foreach($gradetotals as $gt){
							$pt=$db->getPoint($gt->grade);
							$gradet=$gradet+$pt;
							$count=$count+1;
						}
						echo "Total Students: ". $totals."</br>";
						//get the mean score of the class
						if($count==0){
							$mean=$gradet/1;
						}else{
							$mean=$gradet/$count;//find the total marks per individual
						}
					//	$rMean=($mean/100)*12;
						// echo $rMean;
            ?>
						<div class="table">
							<button class="badge badge-success fa fa-print ml-auto" style="margin-top:10px;" name="print">&nbsp;&nbsp;<a href="printMeans.php" style="color:white">Print Means</a></button>
							<table class="table">
								<tr>
									<td><?php echo "Form\t".$_SESSION['class']."\t".$_SESSION['stream']." Mean Score";?></td>
								</tr>
								<tr>
									<td><?php echo $mean;?></td>
									<?php if($_SESSION['class']!=""){?>
									<td><form method="POST" action="rank.php">
										<input type="hidden" name="tot" value="<?php echo $mean;?>"/>
										<input type="hidden" name="stream" value="<?php echo $_SESSION['stream'];?>"/>
										<input type="hidden" name="exam" value="<?php echo $_SESSION['exam'];?>"/>
										<input type="submit" class="btn btn-success" value="Update Mean" name="upMean">
									</form></td>
								<?php } ?>
								</tr>
							</table>
						</div>
					<?php }?>
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
