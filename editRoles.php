<?php
session_start();
$Msg="";
require_once('Database.php');
$id=$_GET['Edit'];
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
	$rId=$_POST['id'];
	$role=$_POST['role'];
	$db=new Database();
	$db->query("UPDATE prole SET prole=:prole WHERE id=:id");
	$db->bind(':prole',$role);
  $db->bind(':id',$rId);
	if($db->execute()){
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Success!!! Role Updated</strong>
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Error!!! Role Not Updated</strong>
		</div>";
	}
}

?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<span style="font-size:20px"><span class="text-primary">Edit Parent Details</span></span>
					<div class="container">
            <?php
            $db=new Database();
            $db->query("select * from prole where id=:id");
            $db->bind(':id',$id);
            if($results=$db->single()){
            ?>
					<form method="POST" action="editRoles.php" enctype="multipart/form-data">
						<?php echo $Msg;?>
						<div class="row">
							<div class="col-sm-6">
								<input type="hidden" class="form-control" name="id" value="<?php echo $id;?>" />
								<label for="" class="label-control">Role</label>&nbsp;<i class="fas fa-star" style="color:red"></i>
									<input type="text" class="form-control" name="role" value="<?php echo $results->prole;?>" required/>
							</div>
						</div>
          <?php
         }
          ?>
						<button class="btn btn-success btn-raised" name="sub" type="submit" style="margin-top:20px">Update Roles</button>
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
