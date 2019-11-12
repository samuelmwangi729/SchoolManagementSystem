<?php
session_start();
require_once('Database.php');
$_SESSION['balClass']="";
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
?>
			<div class="app-content">

						<?php include('include/header.php');?>
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
            View Students
						<?php
            if(isset($_POST['sub'])){
              $_SESSION['balClass']=$_POST['class'];
            }
						?>
            <form method="POST" action="viewBalances.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Please select Class To view Balances</strong></legend>
								<div class="row">
									<div class="col-sm-4">
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
									<div class="col-sm-4">
										<br>
										<button class="badge badge-success fa fa-upload" style="margin-top:10px;" name="sub">&nbsp;&nbsp;Select Class</button>
									</div>
								</div>
							</fieldset>
						</form>
            <div class="table table-responsive">
              <?php
              if(!$_SESSION['balClass']==""){?>
                <a href="printBalance.php?Class=<?php echo $_SESSION['balClass'];?>" target="_blank" class="badge badge-success fa fa-print" style="float:right;margin-bottom:5px">Print Report</a>
              <?php }?>
    					<table class="table table-striped table-codensed table-hover table-bordered">
    						<thead class="text-center">
    							<tr>
										<td>Passport</td>
    								<td>Names</td>
    								<td>Reg Number</td>
    								<td>Class</td>
    								<td>Stream</td>
    								<td>Parent</td>
    								<td>Fees</td>
    								<td>Balance</td>
    							</tr>
    						</thead>
    						<tbody>
									<?php
									$database=new Database();
                  if($_SESSION['balClass']==""){
                    $database->query("SELECT * FROM student WHERE Year=:year");
                    $database->bind(':year',date('Y'));
                    $results=$database->resultSet();
                  }else{
                    $database->query("SELECT * FROM student WHERE Class=:class AND Year=:year");
                    $database->bind(':class',$_SESSION['balClass']);
                    $database->bind(':year',date('Y'));
                    $results=$database->resultSet();
                  }
									foreach ($results as $key) {
										$status="";
									?>
									<tr><?php if($key->photo==""){
										$img="default.png";
									}else{
										$img=$key->photo;
									}?>
											<td><img src="<?php echo "Student/".$img;?>" width="30px" height="30px" style="border-radius:25px"></td>
											<td><?php echo $key->names;?></td>
											<td><?php echo $key->regNo;?></td>
											<td><?php echo $key->class;?></td>
											<td><?php echo $key->stream;?></td>
											<td><?php echo $key->parent;?></td>
											<td><?php echo $key->fees;?></td>
											<?php
                      if($key->balance<=0){
                        echo "<td class='text-danger'>Cleared</td>";
                      }else{
                          echo "<td style='color:red'>".$key->balance."</td>";
                      }
                      ?>
									</tr>
								<?php }?>
    						 </tbody>
    					 </table>
    				</div>
						<!-- start: PAGE TITLE -->
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
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
