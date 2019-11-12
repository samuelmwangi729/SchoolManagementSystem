<?php
session_start();
require_once('Database.php');
$Msg="";
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
	$receiptNumber=$_POST['receiptNumber'];
	$studentReg=$_POST['admission'];
	$term=$_POST['term'];
	$year=date('Y');
	$amount=$_POST['amount'];
	$database=new Database();
	$database->query("SELECT class FROM student WHERE regNo=:regNo");
	$database->bind(':regNo',$studentReg);
	$database->execute();
	$class=$database->fetchColumn();
	$database->query("INSERT INTO payments(studentReg,term,Amount,class,mode,Date,Year,receiptNumber) VALUES(:studentReg,:term,:amount,:class,:mode,:date,:year,:receiptNumber)");
	$database->bind(':studentReg',$studentReg);
	$database->bind(':term',$term);
	$database->bind(':amount',$amount);
	$database->bind(':class',$class);
	$database->bind(':mode',$_POST['mode']);
	$database->bind(':date',date("Y-M-d"));
	$database->bind(':year',$year);
	$database->bind(':receiptNumber',$receiptNumber);
	if($database->execute()){
		//update the students balances
	$database->updateIndBalance($studentReg,$amount);
		//update the balances

		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Fees Collection Successfully Recorded </strong>
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Error!!!!Fees Collection Not Recorded </strong>
		</div>";
	}
}
?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<form method="POST" action="payFees.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>School Fees Payment For Term <?php $database=new Database();
								$database->query("SELECT currentSession FROM currentsession");
								$database->execute();
								echo $database->fetchColumn();
									?></strong></legend>
								<div class="row">
									<div class="col-sm-3">
										<input type="hidden" name="receiptNumber" value="<?php
										$db=new Database();
										echo $db->count('payments')+$db->getStartReceipt();?>"/>
										<label for="voteHead" class="label-control">Admission Number</label>
										<select name="admission" class="form-control">
											<option>--ADMISSION NUMBER--</option>
											<?php $database=new Database();
											$results=$database->displayApproved('student');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->regNo;?></option>
										<?php }?>
										</select>
									</div>
									<div class="col-sm-3">
										<label for="voteHead" class="label-control">Payment Mode</label>
										<select name="mode" class="form-control">
											<option>Cash </option>
											<option>Cheque</option>
											<option>Others</option>
										</select>
									</div>
									<div class="col-sm-3">
										<label for="term" class="label-control">TERM</label>
										<input type="text" name="term" class="form-control" value="<?php $database=new Database();
										$database->query("SELECT currentSession FROM currentsession");
										$database->execute();
										echo $database->fetchColumn();
											?>" readonly/>
									</div>
									<div class="col-sm-3">
										<label for="Amount" class="label-control">Amount</label>
										<input class="form-control" name="amount" type="number" required/>
									</div>
									<br>
									<button class="badge badge-success" name="sub" style="margin-top:5px;margin-left:18px;">Make Payment</button>
								</div>
							</fieldset>
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
