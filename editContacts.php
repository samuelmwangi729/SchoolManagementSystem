<?php
session_start();
require_once('Database.php');
if(isset($_SESSION['role'])){
	$id=$_GET['Edit'];
	$Msg="";
	include('head.php');
	if(isset($_POST['sub'])){
	  $sName=$_POST['sname'];
	  $Phone=$_POST['phone'];
	  $pBox=$_POST['pbox'];
	  $pCode=$_POST['pcode'];
	  $pCity=$_POST['pcity'];
	  $sReceipt=$_POST['sReceipt'];
	  $db=new Database();
	  $db->query('UPDATE settings SET sName=:sName,Phone=:Phone,pBox=:pBox,pCode=:pCode,pCity=:pCity,sReceipt=:sReceipt');
	  $db->bind(':sName',$sName);
	  $db->bind(':Phone',$Phone);
	  $db->bind(':pBox',$pBox);
	  $db->bind(':pCode',$pCode);
	  $db->bind(':pCity',$pCity);
	  $db->bind(':sReceipt',$sReceipt);
	  $status=$db->execute();
	  if($status){
	  $Msg="<div class='alert alert-success'id='alert'>
				<strong>Success!!! Contact Details Updated</strong>
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
					<form method="POST" action="editContacts.php">
						<?php echo $Msg;
						$database=new Database();
						$database->query('SELECT * FROM settings');
						$database->execute();
						if($details=$database->single()){
						?>
						<fieldset>
							<legend style="border:0px;font-size:30px;"><strong>Edit School Contacts</strong></legend>
							<div class="row">
								<div class="col-sm-3">
									<input type="hidden" value="<?php echo $details->id;?>"/>
									<label for="Subject" class="label-control">School Name</label>&nbsp;<i class="fa fa-university" style="color:red"></i>
									<input type="text" class="form-control" placeholder="Eg. Munyeki Secondary School" required name="sname" value="<?php echo $details->sName;?>" />
								</div>
								<div class="col-sm-3">
									<label for="Subject" class="label-control">Phone Number</label>&nbsp;<i class="fas fa-phone-alt" style="color:red"></i>
									<input type="number" class="form-control" required placeholder="Eg.0704922943" name="phone" value="<?php echo $details->Phone;?>" />
								</div>
								<div class="col-sm-3">
									<label for="Subject" class="label-control">Office Box</label>&nbsp;<i class="fa fa-cog" style="color:red"></i>
										<input type="number" class="form-control" required placeholder="Eg.100" name="pbox" value="<?php echo $details->pBox;?>" />
								</div>
								<div class="col-sm-3">
									<label for="Subject" class="label-control">Postal Code</label>&nbsp;<i class="fa fa-tag" style="color:red"></i>
										<input type="text" class="form-control" required placeholder="Eg.20304" name="pcode" value="<?php echo $details->pCode;?>" />
								</div>
								<div class="col-sm-3">
									<label for="Subject" class="label-control">City /Town</label>&nbsp;<i class="fas fa-city" style="color:red"></i>
										<input type="text" class="form-control" required placeholder="Eg.Nakuru" name="pcity" value="<?php echo $details->pCity;?>" />
								</div>
								<div class="col-sm-3">
									<label for="Subject" class="label-control">Receipt Number</label>&nbsp;<i class="fas fa-city" style="color:red"></i>
										<input type="text" class="form-control" required placeholder="Eg.1901" name="sReceipt" value="<?php echo $details->sReceipt;?>" />
								</div>
								<div class="col-sm-3">
									<br>
									<button class="badge badge-success fa fa-upload" style="margin-top:10px;" name="sub" <?php echo $disabled;?> >&nbsp;&nbsp;Update Details</button>
								</div>
							</div>
						</fieldset>
					<?php } ?>
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
