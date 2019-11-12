<?php
session_start();
$_SESSION['query']="SELECT * FROM subjectteachers";
require_once('Database.php');
if(isset($_SESSION['role'])){
	$Msg="";
	include('head.php');
	if(isset($_POST['sub'])){
		//handle the button event
		$teacherName=$_POST['name'];
		$subject=$_POST['subject'];
		$class=$_POST['class'];
		$stream=$_POST['stream'];
		//insert into the database
		$db=new Database();
		$db->query('INSERT INTO subjectteachers(teacherName,Subject,class,stream) VALUES(:teacherName,:Subject,:class,:stream)');
		$db->bind(':teacherName',$teacherName);
		$db->bind(':Subject',$subject);
		$db->bind(':class',$class);
		$db->bind(':stream',$stream);
	if(	$db->execute()){
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Subjects Assigned Successfully</strong>
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Could Not Assign Classes</strong>
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
  $status=$db->activate('subjectteachers','status',$id);
  if($status){
    $Msg="<div class='alert alert-success'id='alert'>
		<a class='close' data-dismiss='alert'>&times;</a>
      <strong>Parent Role Approved!!</strong>
    </div>";
  }
}
if(isset($_GET['Deactivate'])){
  $id=$_GET['Deactivate'];
  $db=new Database();
  $status=$db->deactivate('subjectteachers','status',$id);
  if($status){
    $Msg="<div class='alert alert-danger'id='alert'>
		<a class='close' data-dismiss='alert'>&times;</a>
      <strong>Class Deallocated!!</strong>
    </div>";
  }else{
    $Msg="<div class='alert alert-danger'id='alert'>
		<a class='close' data-dismiss='alert'>&times;</a>
      <strong>Could not Suspend!!</strong>
    </div>";
  }
}
?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
						<form method="POST" action="assignTeacher.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Assign Subjects to  Teachers</strong></legend>
								<div class="row">
									<div class="col-sm-3">
										<label for="ClassName" class="label-control">Teacher Name</label>
										<select name="name" class="form-control">
											<option>--TEACHER NAME--</option>
											<?php $database=new Database();
											$database->query('SELECT * FROM teacher WHERE role=:role');
											$database->bind(':role','teacher');
											$results=$database->resultSet();
											foreach ($results as $key) {
											?>
											<option><?php echo $key->names;?></option>
										<?php }?>
										</select>
									</div>
									<div class="col-sm-3">
										<label for="ClassName" class="label-control">Teaching Subject</label>
										<select name="subject" class="form-control">
											<option>--TEACHING SUBJECT--</option>
											<?php $database=new Database();
											$results=$database->displayApproved('subject');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->subjectName;?></option>
										<?php }?>
										</select>
									</div>
									<div class="col-sm-3">
										<label for="ClassName" class="label-control">Teaching Class</label>
										<select name="class" class="form-control">
											<option>--SELECT CLASS--</option>
											<?php $database=new Database();
											$results=$database->displayApproved('classes');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->form;?></option>
										<?php }?>
										</select>
									</div>
									<div class="col-sm-3">
										<label for="ClassName" class="label-control">_STREAM</label>
										<select name="stream" class="form-control">
											<option>--SELECT STREAM--</option>
											<?php $database=new Database();
											$results=$database->displayApproved('stream');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->streamName;?></option>
										<?php }?>
										</select>
									</div>
									<br>
									<button class="badge badge-success" name="sub" style="margin-top:20px;margin-left:18px;">Assign Class</button>
								</div>
							</fieldset>
						</form>
								<form method="GET" action="assignTeacher.php" class="form-inline" style="float:right">
									<input type="text" class="form-control" name="search" placeholder="Search Teacher" required/>
								  <button type="submit" class="btn btn-primary" name="sub"><i class="fa fa-search"></i></button>
								</form>
            <div class="table table-responsive">
              Teachers &amp; Their Assigned Subjects
              <table class="table table-striped table-condensed table-hover table-bordered">
                <?php echo $Msg1;?>
                <thead class="text-center">
                  <tr>
                    <td>Names</td>
                    <td>Subject</td>
                    <td>Class</td>
                    <td>Stream</td>
                    <td>Action</td>
                  </tr>
                </thead>
                <tbody>
                  <?php
									if(isset($_GET['sub'])){
										$_SESSION['query']="SELECT * FROM subjectteachers WHERE TeacherName=:teacherName";
										$db=new Database();
										$db->query('SELECT * FROM subjectteachers WHERE TeacherName=:teacherName');
										$db->bind(':teacherName',$_GET['search']);
										$results=$db->resultSet();
										foreach ($results as $key) {
	                    $status="";
	                  ?>
	                  <tr>
	                    <td><?php echo $key->teacherName;?></td>
	                    <td><?php echo $key->Subject;?></td>
	                    <td><?php echo $key->class;?></td>
	                    <td><?php echo $key->stream;?></td>
	                    <td><?php
	                    if($key->status==1){
	                      $status=1;
	                      echo "<span style='color:green;'>Acting</span>";
	                    }else{
	                      $status=0;
	                      echo "<span style='color:red;'>Replaced</span>";
	                    }
	                    ?></td>
	                    <td><?php
	                    if($status==1){
	                      echo "<a href='assignTeacher.php?Deactivate={$key->id}' class='badge badge-danger'><i class='fa fa-times'>&nbsp;Suspend</i></a>";
	                    }else{
	                      echo "<a href='assignTeacher.php?Activate={$key->id}' class='badge badge-success'><i class='fa fa-check'>&nbsp;Approve</i></a>";
	                    }
	                    ?></td>
	                  </tr>
	                <?php }
									}else{
                  $database=new Database();
                  //$results=$database->displayTable('subjectTeachers');
									$database->query($_SESSION['query']);
									$database->execute();
									$results=$database->resultSet();
                  foreach ($results as $key) {
                    $status="";
                  ?>
                  <tr>
                    <td><?php echo $key->teacherName;?></td>
                    <td><?php echo $key->Subject;?></td>
                    <td><?php echo $key->class;?></td>
                    <td><?php echo $key->stream;?></td>
                    <td><?php
                    if($key->status==1){
                      $status=1;
                      echo "<span style='color:green;'>Acting</span>";
                    }else{
                      $status=0;
                      echo "<span style='color:red;'>Replaced</span>";
                    }
                    ?></td>
                    <td><?php
                    if($status==1){
                      echo "<a href='assignTeacher.php?Deactivate={$key->id}' class='badge badge-danger'><i class='fa fa-times'>&nbsp;Suspend</i></a>";
                    }else{
                      echo "<a href='assignTeacher.php?Activate={$key->id}' class='badge badge-success'><i class='fa fa-check'>&nbsp;Approve</i></a>";
                    }
                    ?></td>
                  </tr>
                <?php }}?>
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
