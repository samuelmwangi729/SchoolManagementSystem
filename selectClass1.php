<?php
session_start();
require_once('Database.php');
if(isset($_SESSION['role'])){
	$Msg="";
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
						<form method="POST" action="printMarkSheet1.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Print Subject MarkSheet</strong></legend>
								<div class="row">
									<div class="col-sm-3">
										<label for="Department" class="label-control">Class</label>&nbsp;<i class="fa fa-bank"style="color:red"></i>
										<select name="class" class="form-control">
											<option>--SELECT CLASSES--</option>
											<?php $database=new Database();
											$results=$database->displayTable('classes');
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
											$results=$database->displayTable('stream');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->streamName;?></option>
										<?php }?>
										<option>All Streams</option>
										</select>
									</div><div class="col-sm-3">
										<label for="Subject" class="label-control">Subject</label>&nbsp;<i class="fa fa-list" style="color:red"></i>
										<select name="subject" class="form-control">
											<?php $database=new Database();
											$results=$database->displayApproved('subject');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->subjectName;?></option>
										<?php }?>
										</select>
									</div>
									<div class="col-sm-3">
										<br>
										<button class="badge badge-success fa fa-print" style="margin-top:10px;" name="sub">&nbsp;&nbsp;Print MarkSheet</button>
									</div>
								</div>
							</fieldset>
						</form>
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
