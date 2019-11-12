<?php
session_start();
error_reporting(0);
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
?>
			<div class="app-content">

						<?php include('include/header.php');?>
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
            Rank Students By Streams
						<?php
						if(isset($_POST['Num'])){
							$_SESSION['exam']=$_POST['exam'];
							$_SESSION['student']=$_POST['student'];
							$_SESSION['class']=$_POST['class'];
							$_SESSION['stream']=$_POST['stream'];
							$_SESSION['year']=$_POST['year'];
							$_SESSION['term']=$_POST['term'];
							$db1=new Database();
							$db1->query('SELECT *  FROM examTotals where  exam=:exam AND Class=:class AND Stream=:stream AND term=:term AND year=:Year ORDER BY total DESC');
							//$db1->bind(':marks',100);
							$db1->bind(':exam',$_POST['exam']);
							$db1->bind(':class',$_POST['class']);
							$db1->bind(':term',$_POST['term']);
							$db1->bind(':Year',$_POST['year']);
							$db1->bind(':stream',$_POST['stream']);
							$cnt=1;
							$pos=$db1->resultSet();
							foreach ($pos as $keyp) {
								$db1->query("UPDATE examTotals SET StreamPosition=:position WHERE  id=:id");
								$db1->bind(':position',$cnt);
								$db1->bind(':id',$keyp->id);
								$db1->execute();
							//	echo $_GET['Num'];
								//echo "Leading student is ".$keyp->studentReg."Highest marks is ".$keyp->total." number". $cnt."</br>";
								$cnt=$cnt+1;
							}
              $Msg="<div class='alert alert-success'id='alert'>
                <a class='close' data-dismiss='alert'>&times;</a>
                <strong>Form ".$_POST['class']."\t".$_POST['stream']." Successfully Ranked !!</strong>
              </div>";
							//echo $cnt;
						}
						?>
			<br/>
			<?php 
			if(isset($_POST['Num'])){?>
				<a href="printStream.php?Exam=<?php echo $_SESSION['exam'];?>&Class=<?php echo $_SESSION['class'];?>&Term=<?php echo $_SESSION['term'];?>&Year=<?php echo $_SESSION['year'];?>&Stream=<?php echo $_SESSION['stream'];?>" class="badge badge-success fa fa-print" style="float:right;margin-bottom:5px;" >&nbsp;Print</a>&nbsp;&nbsp;&nbsp;&nbsp;		
			<?php }?>
            	<a href="resultsClass.php" class="badge badge-warning fa fa-home" style="float:right;margin-bottom:5px;" >&nbsp;Back To Class Results?</a>&nbsp;&nbsp;
						<form method="POST" action="rankClass.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Please select the Details</strong></legend>
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
									<div class="col-sm-2">
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
									<div class="col-sm-2">
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
										<label for="term" class="label-control">SELECT TERM</label>
										<select name="term" class="form-control">
											<option><?php echo " I";?></option>
											<option><?php echo " II";?></option>
											<option><?php echo " III";?></option>
										</select>
									</div>
									<div class="col-sm-2">
										<label for="term" class="label-control">SELECT STREAM</label>
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
										<br>
										<button type="submit" class="badge badge-success fa fa-upload" style="margin-top:10px;" name="Num">&nbsp;&nbsp;Select Details</button>
									</div>
								</div>
							</fieldset>
						</form>
    				</div>
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
