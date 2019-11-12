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
  $term=$_POST['term'];
  $db=new Database();
	$nextTerm=$db->getNextTerm();
	if($term == $nextTerm){
		$results=$db->displaynTFees($class,$term);
	}else{
		$results=$db->displayFees($class,$term);
	}
  $total=0;
  foreach ($results as $key) {
    $total=$total+$key->amount;
  }
	//set the fees to everyone
  $db->query("UPDATE student SET fees=:fees WHERE class=:class AND status=:status");
  $db->bind(':fees',$total);
  $db->bind(':class',$class);
  $db->bind(':status',1);
  if($db->execute()){
		//update the balances
		$db->updateClassBalance($class,$total);
    $Msg="<div class='alert alert-success'id='alert'>
      <strong>Success!!! Form ".$class." Invoiced</strong>
    </div>";
  }else{
    $Msg="<div class='alert alert-danger'id='alert'>
      <strong>Error!!! The class Could Not Be Invoiced</strong>
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
						<form method="POST" action="generateInvoice.php">
              <fieldset>
                <legend style="border-bottom:1px solid red">
                  Generate Invoice
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
                  <div class="col-sm-6">
                    <label for="term" class="label-control fa fa-check-circle" style="color:red">&nbsp;&nbsp;TERM</label>
                    <input type="text" name="term" class="form-control" value="<?php $database=new Database();
                    $database->query("SELECT currentSession FROM currentsession");
                    $database->execute();
                    echo $database->fetchColumn();
                      ?>" readonly/>
                  </div>
                  <br>
                <div class="col-sm-6">
                  <button style="margin-top:30px;" class="btn btn-success fa fa-paper-plane" type="submit" name="sub">&nbsp;&nbsp;Invoice</button>
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
