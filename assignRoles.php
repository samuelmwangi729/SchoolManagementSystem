<?php
session_start();
require_once('Database.php');
if(isset($_SESSION['role'])){
	$Msg="";
	include('head.php');
	if(isset($_POST['sub'])){
		//handle the button event
		$empNumber=$_POST['empNumber'];
		$tableName="teacher";
		$field="designation";
		$designation=$_POST['designation'];
		//insert into the database
		$db=new Database();
	if(	$db->role($tableName,$field,$designation,$empNumber)){
		//if true
		$db->role($tableName,"roled","1",$empNumber);
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Parent role Successfully Assigned</strong>
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Parent Role Assignment Failed</strong>
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
  $status=$db->activate('teacher','status',$id);
  if($status){
    $Msg="<div class='alert alert-success'id='alert'>
      <strong>Parent Role Approved!!</strong>
    </div>";
  }
}
if(isset($_GET['Deactivate'])){
  $id=$_GET['Deactivate'];
  $db=new Database();
  $status=$db->deactivate('teacher','status',$id);
  if($status){
    $Msg="<div class='alert alert-danger'id='alert'>
      <strong>Parental Role Suspended!!</strong>
    </div>";
  }else{
    $Msg="<div class='alert alert-danger'id='alert'>
      <strong>Could not Suspend!!</strong>
    </div>";
  }
}
if(isset($_GET['Delete'])){
  // $id=$_GET['Delete'];
  // $db=new Database();
  // $delete=$db->delete('classes',$id);
  // if($delete){
  // 	echo "<div class='alert alert-danger'id='alert'>
  // 		<strong>Class deleted!!</strong>
  // 	</div>";
  // }else{
  // 	echo "<div class='alert alert-danger'id='alert'>
  // 		<strong>Class Not Deleted!!</strong>
  // 	</div>";
  // }
}
?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
						<form method="POST" action="assignRoles.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Assign Roles To Parent</strong></legend>
								<div class="row">
									<div class="col-sm-6">
										<label for="ClassName" class="label-control">PARENT NAME</label>
										<select name="empNumber" class="form-control">
											<option>--SELECT NAME--</option>
											<?php $database=new Database();
											$results=$database->displayParent('teacher');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->names;?></option>
										<?php }?>
										</select>
									</div>
									<div class="col-sm-6">
										<label for="ClassName" class="label-control">Parent's Roles</label>
										<select name="designation" class="form-control">
											<option>--SELECT ROLE--</option>
											<?php $database=new Database();
											$results=$database->displayApproved('prole');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->prole;?></option>
										<?php }?>
										</select>
									</div>
									<br>
									<button class="badge badge-success" name="sub" style="margin-top:20px;margin-left:18px;">Assign Role</button>
								</div>
							</fieldset>
						</form>
            <div class="table table-responsive">
              Parent &amp; Their Assigned Roles
              <table class="table table-striped table-condensed table-hover table-bordered">
                <?php echo $Msg1;?>
                <thead class="text-center">
                  <tr>
                    <td>Names</td>
                    <td>Role</td>
                    <td>Status</td>
                    <td>Action</td>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $database=new Database();
                  $results=$database->displayroledParent('teacher');
                  foreach ($results as $key) {
                    $status="";
                  ?>
                  <tr>
                    <td><?php echo $key->names;?></td>
                    <td><?php echo $key->designation;?></td>
                    <td><?php
                    if($key->status==1){
                      $status=1;
                      echo "<span style='color:green;'>Acting</span>";
                    }else{
                      $status=0;
                      echo "<span style='color:red;'>Suspended</span>";
                    }
                    ?></td>
                    <td><?php
                    if($status==1){
                      echo "<a href='assignRoles.php?Deactivate={$key->id}' class='badge badge-danger'><i class='fa fa-times'>&nbsp;Suspend</i></a>";
                    }else{
                      echo "<a href='assignRoles.php?Activate={$key->id}' class='badge badge-success'><i class='fa fa-check'>&nbsp;Approve</i></a>";
                    }
                    ?></td>
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
