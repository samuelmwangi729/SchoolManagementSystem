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
if(isset($_POST['sub'])){
	$_SESSION['exam']=$_POST['exam'];
	$_SESSION['student']=$_POST['student'];
	$_SESSION['class']=$_POST['class'];
	$_SESSION['stream']=$_POST['stream'];
	$_SESSION['year']=$_POST['year'];
	$_SESSION['term']=$_POST['term'];
}

?>
			<div class="app-content">

						<?php include('include/header.php');?>
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
            Manage Exam Results
						<?php
						if(isset($_GET['Trun'])){
							$db=new Database();
							$db->query('TRUNCATE TABLE eresults');
							$db->execute();
							$db->query('TRUNCATE TABLE examtotals');
							$db->execute();
							$db->query('TRUNCATE TABLE cattotals');
							$db->execute();
							$db->query('TRUNCATE TABLE averageresults');
							$db->execute();
							$db->query('TRUNCATE TABLE averagetotals');
							$db->execute();
							$db->query('TRUNCATE TABLE isavposted');
							$db->execute();
						}
						if(isset($_GET['Num'])){
							$db1=new Database();
							if($_GET['Class']==3 || $_GET['Class']==4){
								$db1->query('SELECT *  FROM examtotals where  exam=:exam AND Class=:class AND term=:term AND year=:Year ORDER BY points DESC');
								$db1->bind(':exam',$_GET['Num']);
								$db1->bind(':class',$_GET['Class']);
								$db1->bind(':term',$_GET['Term']);
								$db1->bind(':Year',$_GET['Year']);
								$cnt=1;
								$pos=$db1->resultSet();
								//echo $_GET['Num'];
								//print_r($pos);
								foreach ($pos as $keyp) {
									$db1->query("UPDATE examtotals SET position=:position WHERE  id=:id");
									$db1->bind(':position',$cnt);
									$db1->bind(':id',$keyp->id);
									$db1->execute();
								//	echo $_GET['Num'];
									//echo "Leading student is ".$keyp->studentReg."Highest marks is ".$keyp->total." number". $cnt."</br>";
									$cnt=$cnt+1;
								}
							}else{
							$db1->query('SELECT *  FROM examtotals where  exam=:exam AND Class=:class AND term=:term AND year=:Year ORDER BY total DESC');
							//$db1->bind(':marks',100);
							$db1->bind(':exam',$_GET['Num']);
							$db1->bind(':class',$_GET['Class']);
							$db1->bind(':term',$_GET['Term']);
							$db1->bind(':Year',$_GET['Year']);
							$cnt=1;
							$pos=$db1->resultSet();
							//echo $_GET['Num'];
							//print_r($pos);
							foreach ($pos as $keyp) {
								$db1->query("UPDATE examtotals SET position=:position WHERE  id=:id");
								$db1->bind(':position',$cnt);
								$db1->bind(':id',$keyp->id);
								$db1->execute();
							//	echo $_GET['Num'];
								//echo "Leading student is ".$keyp->studentReg."Highest marks is ".$keyp->total." number". $cnt."</br>";
								$cnt=$cnt+1;
							}
						}
						}
						?>
						<form method="POST" action="resultsClass.php">
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
									<div class="col-sm-3">
										<br>
										<button class="badge badge-success fa fa-upload" style="margin-top:10px;" name="sub">&nbsp;&nbsp;Select Details</button>
									</div>
								</div>
							</fieldset>
						</form>
						<?php if($_SESSION['exam']==""){
							//
						}else{
						?>
						<a href="resultsClass.php?Trun=<?php echo $_SESSION['class'];?>" class="badge badge-danger fa fa-times-circle" style="float:right;margin-bottom:5px;" >&nbsp;Error Ranking?</a>&nbsp;&nbsp;
						<a href="classMarksheet.php" class="badge badge-success fa fa-print" style="float:right;margin-bottom:5px;" >&nbsp;Correction Sheets</a>&nbsp;&nbsp;
						<a href="printClass.php?Exam=<?php echo $_SESSION['exam'];?>&Class=<?php echo $_SESSION['class'];?>&Term=<?php echo $_SESSION['term'];?>&Year=<?php echo $_SESSION['year'];?>" class="badge badge-success fa fa-print" style="float:right;margin-bottom:5px;" >&nbsp;Print</a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="rankClass.php" class="badge badge-warning fa fa-arrow-up" style="float:right;margin-bottom:5px;" >&nbsp;Rank Per Stream</a>
						<a href="resultsClass.php?Num=<?php echo $_SESSION['exam'];?>&Class=<?php echo $_SESSION['class'];?>&Term=<?php echo $_SESSION['term'];?>&Year=<?php echo $_SESSION['year'];?>" class="badge badge-info fa fa-arrow-up" style="float:right;margin-bottom:5px;" >&nbsp;Generate Numbers</a>&nbsp;&nbsp;&nbsp;
						<a href="resultsSub.php?Num=<?php echo $_SESSION['exam'];?>&Class=<?php echo $_SESSION['class'];?>&Term=<?php echo $_SESSION['term'];?>&Year=<?php echo $_SESSION['year'];?>" class="badge badge-primary fa fa-check-circle" style="float:right;margin-bottom:5px;" >&nbsp;Subject Performance</a> &nbsp;&nbsp;&nbsp;&nbsp;
						<a href="classAverage.php" class="badge badge-primary fa fa-eye" style="float:right;margin-bottom:5px;" >&nbsp;Class Averages</a> &nbsp;&nbsp;&nbsp;&nbsp;
					<?php } ?><div class="table table-responsive">
    					<table class="table table-striped table-codensed table-hover table-bordered">
    						<thead class="text-center">
    							<tr>
										<td style="font-size:8px;font-family:courier">S/N</td>
										<td style="font-size:8px;font-family:courier">Names</td>
										<?php
										$db=new Database();
										$subjects=$db->displayTable('subject');
										foreach ($subjects as $key ) {
											echo "<td style='font-size:8px;font-family:courier'>".$key->subjectAbbr."</td>";
										}
										?>
										<td style="font-size:8px;font-family:courier">Total</td>
										<td style="font-size:8px;font-family:courier">Grade</td>
										<td style="font-size:8px;font-family:courier">Sujbects</td>
										<td style="font-size:8px;font-family:courier">Position</td>
    							</tr>
    						</thead>
    						<tbody>
								<tr>
									<?php
									$database=new Database();
									if($_SESSION['exam']=="" ||$_SESSION['class']==""){
										$database->query("SELECT * FROM student  WHERE class=:class AND status=:status");
										$database->bind(':class',1);
										$database->bind(':status',1);
										echo "<div class='alert alert-danger'id='alert'>
											<strong>No Details Selected!!Please Fill the Above form</strong>
										</div>";
									}else{
										$database->query("SELECT * FROM student  WHERE class=:class AND status=:status ");
										$database->bind(':class',$_SESSION['class']);
										$database->bind(':status',1);
								  $results=$database->resultSet();
									if($database->rowCount()==0){
										echo "<div class='alert alert-danger'id='alert'>
											<strong>No record Found!!</strong>
										</div>";
									}else{
									foreach ($results as $key1) {
										$status="";
									?>
											<td style="font-size:8px;font-family:courier"><?php echo $key1->regNo;?></td>
											<td style="font-size:8px;font-family:courier"><?php
											echo $key1->names;
											?></td>

											<?php
											//for every subject get the marks
											$subjects=$db->displayTable('subject');
											$term=$_SESSION['term'];
											$markx=0;
											$count=0;
											$totalPoints=0;
											foreach ($subjects as $key ) {
												$mark=$db->getMarks($key->subjectName,$_SESSION['class'],$_SESSION['exam'],$_SESSION['year'],$key1->regNo);
												$grade=$db->getSubjectGrade($key->subjectName,$_SESSION['class'],$_SESSION['exam'],$_SESSION['year'],$key1->regNo);
												$sp=$db->getPoint($grade);
												$totalPoints=$totalPoints+$sp;
												$markx=$markx+$mark;
												if($mark=="--"){
													echo "<td style='font-size:8px;font-family:courier'>".$mark." -- </td>";
												}else{
													echo "<td style='font-size:8px;font-family:courier'>".$mark." ".$grade."</td>";
												}

												//check if the totals have been posted
												if($mark==0){
													//
												}else{
													$count=$count+1;
												}

											}
											if($count==0){
												echo "--";
											}else{
												$grade=round($totalPoints/$count);
												if($grade==12){
													$g="A";
												}elseif ($grade==11) {
													$g='A-';
												}elseif($grade==10){
													$g='B+';
												}elseif($grade==9){
													$g='B';
												}elseif ($grade==8) {
													$g='B-';
												}elseif($grade==7){
													$g='C+';
												}elseif ($grade==6) {
													$g='C';
												}elseif($grade==5){
													$g='C-';
												}elseif ($grade==4) {
													$g='D+';
												}elseif ($grade==3) {
													$g='D';
												}elseif ($grade==2) {
													$g='D-';
												}else{
													$g='E';
												}
											$isUpdated=$db->checkExam($_SESSION['exam'],$_SESSION['class'],$_SESSION['year'],$_SESSION['term']);
											if($isUpdated){//update examTotals set points=1,Grade='A' where id=4 AND class=1
												$db->query("UPDATE  examtotals SET total=:total,points=:points,MeanScore=:meanScore,Grade=:grade WHERE studentReg=:studentReg AND exam=:exam AND Class=:class AND Stream=:stream AND term=:term AND year=:year");
												$db->bind(':studentReg',$key1->regNo);
												$db->bind(':exam',$_SESSION['exam']);
												$db->bind(':total',$markx);
												$points=round($markx/$count);
												$db->bind(':points',$totalPoints);
												$db->bind(':meanScore',$grade);
												$db->bind(':grade',$g);
												$db->bind(':class',$_SESSION['class']);
												$db->bind(':stream',$key1->stream);
												$db->bind(':term',$term);
												$db->bind(':year',$_SESSION['year']);
												$db->execute();
											}else{
												$db->query("INSERT INTO examtotals(studentReg,exam,total,points,MeanScore,Grade,Class,Stream,term,year) VALUES(:studentReg,:exam,:total,:points,:meanScore,:grade,:class,:stream,:term,:year)");
												$db->bind(':studentReg',$key1->regNo);
												$db->bind(':exam',$_SESSION['exam']);
												$db->bind(':total',$markx);
												$points=round($markx/$count);
												$db->bind(':points',$totalPoints);
												$db->bind(':meanScore',$grade);
												$db->bind(':grade',$g);
												$db->bind(':class',$_SESSION['class']);
												$db->bind(':stream',$key1->stream);
												$db->bind(':term',$term);
												$db->bind(':year',$_SESSION['year']);
												$db->execute();

												// echo $key1->regNo,$term;
											}
											?>
											<td style='font-size:8px;font-family:courier'><?php
											echo $markx;
											 ?></td>
											<td style='font-size:8px;font-family:courier'><?php
												echo $g;
											}
											 ?></td>
											 <td style="font-family:courier;font-size:8px"><?php echo $count;?></td>
											 <td style="font-family:courier;font-size:8px"><?php
													$positionc=$db->getPosition($key1->regNo,$_SESSION['exam'],$_SESSION['class'],$term,$_SESSION['year']);
													if($positionc <=5){
														echo "<span style='color:red;font-weight:bold;font-size:20px'>".$positionc."</span>";
													}else{
														echo $positionc;
													}
											 ?></td>
										</tr>
								<?php } }}
								if($_SESSION['exam'] == "" || $_SESSION['class']==""){
									//just do nothing
								}else{
									$notEmpty=$db->checkExam($_SESSION['exam'],$_SESSION['class'],$_SESSION['year'],$_SESSION['term']);
									if($notEmpty){
										//just do nothing
									}else{
									$db->query("INSERT INTO eresults(exam,class,year,term) VALUES(:exam,:class,:year,:term)");
									$db->bind(':exam',$_SESSION['exam']);
									$db->bind(':class',$_SESSION['class']);
									$db->bind(':year',$_SESSION['year']);
									$db->bind(':term',$_SESSION['term']);
									$db->execute();
								}
								}
								?>
    						 </tbody>
    					 </table>
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
