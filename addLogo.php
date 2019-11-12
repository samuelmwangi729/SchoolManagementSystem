<?php
session_start();
$Msg="";
include('Database.php');
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
if(isset($_POST['upl'])){
  $file=$_FILES['logo']['name'];
  $tmpName=$_FILES['logo']['tmp_name'];
  move_uploaded_file($tmpName, "assets/images/$file");
  $db=new Database();
  $db->query("UPDATE settings SET Image=:image WHERE id=:id");
  $db->bind(':image',$file);
  $db->bind(':id',1);
  $state=$db->execute();
  if($state){
    $Msg="<div class='alert alert-success'id='alert'>
  			<strong>Success!!! Logo Successfully Added</strong>
  		</div>";
  }
}
?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
            <div class="form-group">
              <form method="POST" action="addLogo.php" enctype="multipart/form-data">
    						<?php echo $Msg;?>
    						<div class="row">
    							<div class="col-sm-3">
                    <label for="Clogo" class="label-control text-primary">Select Logo</label>
      							<input type="file" name="logo" class="form-control" required="true">
                  </div>
                  	<button type="submit" class="btn btn-primary btn-raised" style="margin-top:20px" name="upl"><i class="fa fa-upload"></i>Upload Logo</button>
    						</div>

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
