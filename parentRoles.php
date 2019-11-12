<?php
session_start();
require_once('Database.php');
if(isset($_SESSION['role'])){
	$Msg="";
  $Msg1="";
	include('head.php');
	if(isset($_POST['sub'])){
		//handle the button event
		$className=$_POST['dName'];
		$tableName="prole";
		$field="prole";
		//insert into the database
		$db=new Database();
	if(	$db->insert($className,$tableName,$field)){
		//if true
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Parent role Successfully  Added</strong>
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Parent role  Not Added</strong>
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
if(isset($_GET['Activate'])){
  $id=$_GET['Activate'];
  $db=new Database();
  $status=$db->activate('prole','status',$id);
  if($status){
    $Msg="<div class='alert alert-success'id='alert'>
      <strong>Parent role Approved!!</strong>
    </div>";
  }
}
if(isset($_GET['Deactivate'])){
  $id=$_GET['Deactivate'];
  $db=new Database();
  $status=$db->deactivate('prole','status',$id);
  if($status){
    $Msg="<div class='alert alert-danger'id='alert'>
      <strong>Parent role Not Approved!!</strong>
    </div>";
  }
}
if(isset($_GET['Delete'])){
  $id=$_GET['Delete'];
  $db=new Database();
  $delete=$db->delete('prole',$id);
  if($delete){
    $Msg= "<div class='alert alert-danger'id='alert'>
      <strong>Parent role deleted!!</strong>
    </div>";
  }else{
    echo "<div class='alert alert-danger'id='alert'>
      <strong>Parent Not Deleted!!</strong>
    </div>";
  }
}
?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
						<form method="POST" action="parentRoles.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Add Parent Role</strong></legend>
								<div class="row">
									<div class="col-sm-6">
										<label for="Parent RoleName" class="label-control">Parent Role</label>
										<input type="text" name="dName" class="form-control" placeholder="Enter the Parent Role Name" required/>
									</div>
									<div class="col-sm-6">
										<br>
										<button class="badge badge-success" name="sub" style="margin-top:10px">Add Parent Role</button>
									</div>
								</div>
							</fieldset>
						</form>
            <div class="table table-responsive">
              Parent Roles
    					<table class="table table-striped table-condensed table-hover table-bordered">
                <?php echo $Msg1;?>
    						<thead class="text-center">
    							<tr>
    								<td>Role</td>
    								<td>Status</td>
										<td colspan="3">Action</td>
    							</tr>
    						</thead>
    						<tbody>
									<?php
									$database=new Database();
									$results=$database->displayTable('prole');
									foreach ($results as $key) {
										$status="";
									?>
									<tr>
										<td><?php echo $key->prole;?></td>
										<td><?php
										if($key->status==1){
											$status=1;
											echo "<span style='color:green;'>Approved</span>";
										}else{
											$status=0;
											echo "<span style='color:red;'>Pending...</span>";
										}
										?></td>
										<td><?php
										if($status==1){
											echo "<a href='parentRoles.php?Deactivate={$key->id}' class='badge badge-danger'><i class='fa fa-times'>&nbsp;Reject</i></a>";
										}else{
											echo "<a href='parentRoles.php?Activate={$key->id}' class='badge badge-success'><i class='fa fa-check'>&nbsp;Approve</i></a>";
										}
										?></td>
										<td><?php 	echo "<a href='editRoles.php?Edit={$key->id}' class='badge badge-primary'><i class='fa fa-edit'>&nbsp;Edit</i></a>";?></td>
										<td><?php 	echo "<a href='parentRoles.php?Delete={$key->id}' class='badge badge-danger'><i class='fa fa-times-circle'>&nbsp;Delete</i></a>";?></td>
									</tr>
								<?php }?>
    						 </tbody>
    					 </table>
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
