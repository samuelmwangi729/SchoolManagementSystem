<?php
session_start();
require_once('Database.php');
$database=new Database();
$database->query("SELECT term FROM nextSession");
$database->execute();
$_SESSION['nterm']=$database->fetchColumn();
if(isset($_SESSION['role'])){
	$Msg="";
	include('head.php');
	if(isset($_POST['sub'])){
		//handle the button event
	$voteHead=$_POST['voteHead'];
	$term=$_POST['term'];
	$class=$_POST['class'];
	$amount=$_POST['amount'];
		//insert into the database
		$db=new Database();
		$db->query("INSERT INTO nextTermFees(votehead,term,class,amount,year) VALUES(:votehead,:term,:class,:amount,:year)");
		$db->bind(':votehead',$voteHead);
		$db->bind(':term',$term);
		$db->bind(':class',$class);
		$db->bind(':amount',$amount);
		$db->bind(':year',date('Y'));
	if(	$db->execute()){
		//if true
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Next Term Fees Successfully Added</strong>
		</div>";
	}else{
		$Msg="<div class='alert alert-danger'id='alert'>
			<strong>Next Term Fees Could Not Be Added</strong>
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
if(isset($_GET['Delete'])){
  $id=$_GET['Delete'];
  $db=new Database();
  $status=$db->DeleteFees('fees',$id);
  if($status){
    $Msg="<div class='alert alert-success'id='alert'>
      <strong>Votehead Deleted!!</strong>
    </div>";
  }else{
    $Msg="<div class='alert alert-danger'id='alert'>
      <strong>Votehead Not Deleted!!</strong>
    </div>";
  }
}
if(isset($_POST['upd'])){
	$term=$_POST['term'];
	$db=new Database();
	$db->query("UPDATE nextSession SET term=:currentSession WHERE id=1");
	$db->bind(':currentSession',$term);
	if($db->execute()){
		$Msg="<div class='alert alert-success'id='alert'>
			<strong>Next Term Updated!!</strong>
		</div>";
	}
}
?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
						<form method="POST" action="nextTerm.php">
							<?php echo $Msg;?>
							<fieldset>
								<legend style="border:0px;font-size:30px;"><strong>Set School Fees for Term <?php $database=new Database();
								$database->query("SELECT term FROM nextSession");
								$database->execute();
								echo $database->fetchColumn();
									?></strong></legend>
								<div class="row">
									<div class="col-sm-3">
										<label for="voteHead" class="label-control">VOTEHEAD</label>
										<select name="voteHead" class="form-control">
											<option>--SELECT VOTEHEAD--</option>
											<?php $database=new Database();
											$results=$database->displayApproved('voteHead');
											foreach ($results as $key) {
											?>
											<option><?php echo $key->voteHead;?></option>
										<?php }?>
										</select>
									</div>
									<div class="col-sm-3">
										<label for="term" class="label-control">TERM</label>
										<input type="text" name="term" class="form-control" value="<?php $database=new Database();
										$database->query("SELECT term FROM nextSession");
										$database->execute();
										echo $database->fetchColumn();
											?>" readonly/>
									</div>
									<div class="col-sm-3">
										<label for="ClassName" class="label-control">Select Class</label>
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
										<label for="Amount" class="label-control">Amount</label>
										<input class="form-control" name="amount" type="number" required/>
									</div>

									<br>
									<button class="badge badge-primary" name="sub" style="margin-top:20px;margin-left:18px;">Set Fees</button>
								</div>
							</fieldset>
						</form>
						<form method="POST" action="nextTerm.php">
						<div class="row">
							<div class="col-sm-6">
								<label for="term" class="label-control">SET NEXT TERM</label>
								<select name="term" class="form-control">
									<option><?php echo " I";?></option>
									<option><?php echo " II";?></option>
									<option><?php echo " III";?></option>
								</select>
							</div>
							<div class="col-sm-6" style="margin-top:28px">
								<button class="badge badge-primary" name="upd" type="submit">Update The Session</button>
							</div>
						</div>
						</form>
						<br>
            <div class="row">
							<div class="col-sm-6">
							 <div class="table table-responsive">
	              <table class="table table-striped table-condensed table-hover table-bordered">
	                <?php echo $Msg1;?>
	                <thead class="text-center">
	                  <tr>
	                    <td colspan="4">FORM 1 Term <?php $database=new Database();
											$database->query("SELECT term FROM nextSession");
											$database->execute();
											$CurrentTerm=$database->fetchColumn();
											echo $CurrentTerm;
												?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="Printn.php?Print=1&Term=<?php echo $CurrentTerm;?>" class="fa fa-print badge badge-success text-right" style="margin-left:200px">Print Fees Structure</a></td>
	                  </tr>
										<tr>
											<td><?php echo "Votehead";?></td>
											<td><?php echo "Amount";?></td>
											<td><?php echo "Action";?></td>
										</tr>
	                </thead>
	                <tbody>
	                  <?php
										$database=new Database();
										$database->query("SELECT term FROM nextSession");
										$database->execute();
										$term=$database->fetchColumn();
	                  $results=$database->displaynTFees(1,$term);
										$total=0;
	                  foreach ($results as $key) {
	                    $status="";
											$total=$total+$key->amount;
	                  ?>
	                  <tr class="text-center">
	                    <td><?php echo $key->votehead;?></td>
	                    <td><?php echo $key->amount;?></td>
	                    <td><?php echo "<a href='nextTerm.php?Edit={$key->id}' class='badge badge-primary'><i class='fa fa-edit'>&nbsp;Edit</i></a>&nbsp;
											<a href='nextTerm.php?Delete={$key->id}' class='badge badge-danger'><i class='fa fa-times'>&nbsp;Delete</i></a>&nbsp;
											<a href='nextTerm.php?View={$key->id}' class='badge badge-warning'><i class='fa fa-eye'>&nbsp;View</i></a>";?></td>
	                  </tr>
	                <?php }?>
	                 </tbody>
									 <tr class="text-center text-bold">
										 <td colspan="2" style="color:red;font-family:courier;">Total</td>
										 <td style="color:red;font-family:courier;"><?php echo $total;?>&nbsp;&nbsp;&nbsp;</td>
									 </tr>
	               </table>
	            </div>
					   	</div>
							<div class="col-sm-6">
							 <div class="table table-responsive">
	              <table class="table table-striped table-condensed table-hover table-bordered">
	                <?php echo $Msg1;?>
	                <thead class="text-center">
	                  <tr>
	                    <td colspan="4">FORM 2 Term <?php $database=new Database();
											$database->query("SELECT term FROM nextSession");
											$database->execute();
											echo $database->fetchColumn();
												?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="Printn.php?Print=2&Term=<?php echo $CurrentTerm;?>" class="fa fa-print badge badge-success text-right" style="margin-left:200px">Print Fees Structure</a></td>
	                  </tr>
										<tr>
											<td><?php echo "Votehead";?></td>
											<td><?php echo "Amount";?></td>
											<td><?php echo "Action";?></td>
										</tr>
	                </thead>
	                <tbody>
	                  <?php
										$database=new Database();
										$database->query("SELECT term FROM nextSession");
										$database->execute();
										$term=$database->fetchColumn();
	                  $results=$database->displaynTFees(2,$term);
										$total=0;
	                  foreach ($results as $key) {
												$total=$total+$key->amount;
	                    $status="";
	                  ?>
	                  <tr class="text-center">
	                    <td><?php echo $key->votehead;?></td>
	                    <td><?php echo $key->amount;?></td>
											<td><?php echo "<a href='nextTerm.php?Edit={$key->id}' class='badge badge-primary'><i class='fa fa-edit'>&nbsp;Edit</i></a>&nbsp;
											<a href='nextTerm.php?Delete={$key->id}' class='badge badge-danger'><i class='fa fa-times'>&nbsp;Delete</i></a>&nbsp;
											<a href='nextTerm.php?Edit={$key->id}' class='badge badge-warning'><i class='fa fa-eye'>&nbsp;View</i></a>";?></td>
	                  </tr>
	                <?php }?>
	                 </tbody>
									 <tr class="text-center text-bold">
										 <td colspan="2" style="color:red;font-family:courier;">Total</td>
										 <td style="color:red;font-family:courier;"><?php echo $total;?>&nbsp;&nbsp;&nbsp;</td>
									 </tr>
	               </table>
	            </div>
					   	</div>
						</div>
            <div class="row">
							<div class="col-sm-6">
							 <div class="table table-responsive">
	              <table class="table table-striped table-condensed table-hover table-bordered">
	                <?php echo $Msg1;?>
	                <thead class="text-center">
	                  <tr>
	                    <td colspan="4">FORM 3 Term <?php $database=new Database();
											$database->query("SELECT term FROM nextSession");
											$database->execute();
											echo $database->fetchColumn();
												?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="Printn.php?Print=3&Term=<?php echo $CurrentTerm;?>" class="fa fa-print badge badge-success text-right" style="margin-left:200px">Print Fees Structure</a></td>
	                  </tr>
										<tr>
											<td><?php echo "Votehead";?></td>
											<td><?php echo "Amount";?></td>
											<td><?php echo "Action";?></td>
										</tr>
	                </thead>
	                <tbody>
	                  <?php
										$database=new Database();
										$database->query("SELECT term FROM nextSession");
										$database->execute();
										$term=$database->fetchColumn();
	                  $results=$database->displaynTFees(3,$term);
										$total=0;
	                  foreach ($results as $key) {
												$total=$total+$key->amount;
	                    $status="";
	                  ?>
	                  <tr class="text-center">
	                    <td><?php echo $key->votehead;?></td>
	                    <td><?php echo $key->amount;?></td>
											<td><?php echo "<a href='nextTerm.php?Edit={$key->id}' class='badge badge-primary'><i class='fa fa-edit'>&nbsp;Edit</i></a>&nbsp;
											<a href='nextTerm.php?Delete={$key->id}' class='badge badge-danger'><i class='fa fa-times'>&nbsp;Delete</i></a>&nbsp;
											<a href='nextTerm.php?View={$key->id}' class='badge badge-warning'><i class='fa fa-eye'>&nbsp;View</i></a>";?></td>
	                  </tr>
	                <?php }?>
	                 </tbody>
									 <tr class="text-center text-bold">
										 <td colspan="2" style="color:red;font-family:courier;">Total</td>
										 <td style="color:red;font-family:courier;"><?php echo $total;?>&nbsp;&nbsp;&nbsp;</td>
									 </tr>
	               </table>
	            </div>
					   	</div>
							<div class="col-sm-6">
							 <div class="table table-responsive">
	              <table class="table table-striped table-condensed table-hover table-bordered">
	                <?php echo $Msg1;?>
	                <thead class="text-center">
	                  <tr>
	                    <td colspan="4">FORM 4 Term <?php $database=new Database();
											$database->query("SELECT term FROM nextSession");
											$database->execute();
											$CurrentTerm=$database->fetchColumn();
											echo $CurrentTerm;
												?> <a href="Printn.php?Print=4&Term=<?php echo $CurrentTerm;?>" class="fa fa-print badge badge-success text-right" style="margin-left:200px">Print Fees Structure</a></td>
	                  </tr>
										<tr>
											<td><?php echo "Votehead";?></td>
											<td><?php echo "Amount";?></td>
											<td><?php echo "Action";?></td>
										</tr>
	                </thead>
	                <tbody>
	                  <?php
										$database=new Database();
										$database->query("SELECT term FROM nextSession");
										$database->execute();
										$term=$database->fetchColumn();
	                  $results=$database->displaynTFees(4,$term);
										$total=0;
	                  foreach ($results as $key) {
	                    $status="";
												$total=$total+$key->amount;
	                  ?>
	                  <tr class="text-center">
	                    <td><?php echo $key->votehead;?></td>
	                    <td><?php echo $key->amount;?></td>
											<td><?php echo "<a href='nextTerm.php?Edit={$key->id}' class='badge badge-primary'><i class='fa fa-edit'>&nbsp;Edit</i></a>&nbsp;
											<a href='nextTerm.php?Delete={$key->id}' class='badge badge-danger'><i class='fa fa-times'>&nbsp;Delete</i></a>&nbsp;
											<a href='nextTerm.php?View={$key->id}' class='badge badge-warning'><i class='fa fa-eye'>&nbsp;View</i></a>";?></td>
	                  </tr>
	                <?php }?>
	                 </tbody>
									 <tr class="text-center text-bold" style="color:red">
										 <td colspan="2">Total</td>
										 <td style="color:red;font-family:courier;"><?php echo $total;?>&nbsp;&nbsp;&nbsp;</td>
									 </tr>
	               </table>
	            </div>
					   	</div>
						</div>
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
