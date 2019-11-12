<?php
session_start();
$Msg="";
require_once('Database.php');
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
  $class=$_POST['class'];
	$db=new Database();
	$term=$db->getCurrentTerm();
  $results=$db->displayFees($class,$term);
  $total=0;
  foreach ($results as $key) {
    $total=$total+$key->amount;
  }
	//update the balances to everyone
	$result=$db->getClasstest($class);
	foreach ($result as $key) {
	 $db->query("SELECT balance FROM student WHERE regNo=:regNo");
	 $db->bind(':regNo',$key->regNo);
	 $db->execute();
	 $balance=$db->fetchColumn();
	 $newBalance=$balance + $total;
	 $db->updateBalance($key->regNo,$newBalance);
	}
  if($db->execute()){
		//update the balances
    $Msg="<div class='alert alert-success'id='alert'>
      <strong>Success!!! Form ".$class." Balances Updated</strong>
    </div>";
  }else{
    $Msg="<div class='alert alert-danger'id='alert'>
      <strong>Error!!! The class Balances Could Not Be Updated</strong>
    </div>";
  }
}

?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
            <?php echo $Msg;?>
						<form method="POST" action="clearBalances.php">
              <fieldset>
                <legend style="border-bottom:1px solid red">
                  Update Balances
                </legend>
                <div class="row">
                  <div class="col-sm-6">
                    <label for="class" class="label-control fa fa-university" style="color:red">&nbsp;&nbsp;Select Class</label>
                    <select name="class" class="form-control">
    									<option>--SELECT CLASSES--</option>
    									<?php $database=new Database();
    									$results=$database->displayApproved('classes');
    									foreach ($results as $key) {
    									?>
    									<option><?php echo $key->form;?></option>
    								<?php }?>
    								</select>
                  </div>
                  <br>
                <div class="col-sm-6">
                  <button style="margin-top:5px;" class="btn btn-success fa fa-check-circle" type="submit" name="sub">&nbsp;&nbsp;Clear Balance</button>
                </div>
                </div>
              </fieldset>
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
