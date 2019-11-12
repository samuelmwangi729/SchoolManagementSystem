<?php
session_start();
require_once('Database.php');
if(isset($_SESSION['role'])){
	$Msg="";
	include('head.php');
	if(isset($_POST['sub'])){
		//handle the button event
		$catName=$_POST['catName'];
		$tableName="catSubject";
		$field="catName";
		//insert into the database
		$db=new Database();
	if(	$db->insert($catName,$tableName,$field)){
		//if true
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Category Successfully Added</strong>
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>An Error Occurred</strong>
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
						<form method="POST" action="catSubjects.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Add A new Subject Category</strong></legend>
								<div class="row">
									<div class="col-sm-6">
										<label for="ClassName" class="label-control">subject Category</label>
										<input type="text" name="catName" class="form-control" placeholder="Enter the Category Name" required/>
									</div>
									<div class="col-sm-6">
										<br>
										<button class="badge badge-success" name="sub" style="margin-top:10px">Add Subject Category</button>
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
