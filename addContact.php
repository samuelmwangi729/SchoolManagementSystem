<?php
$Msg;
$readOnly="";
$disabled="";
session_start();
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
}else{
	include('include/asidebar.php');
}
if(isset($_POST['sub'])){
  $sName=$_POST['sname'];
  $Phone=$_POST['phone'];
  $pBox=$_POST['pbox'];
  $pCode=$_POST['pcode'];
  $pCity=$_POST['pcity'];
  $bName=$_POST['bName'];
  $aNumber=$_POST['aNumber'];
	$sReceipt=$_POST['sReceipt'];
  $db=new Database();
  $db->query('INSERT INTO settings(sName,Phone,pBox,pCode,pCity,bName,aNumber,sReceipt) VALUES(:sName,:Phone,:pBox,:pCode,:pCity,:bName,:aNumber,:sReceipt)');
  $db->bind(':sName',$sName);
  $db->bind(':Phone',$Phone);
  $db->bind(':pBox',$pBox);
  $db->bind(':pCode',$pCode);
  $db->bind(':pCity',$pCity);
  $db->bind(':bName',$bName);
  $db->bind(':aNumber',$aNumber);
  $db->bind(':sReceipt',$sReceipt);
  $status=$db->execute();
  if($status){
  $Msg="<div class='alert alert-success'id='alert'>
			<strong>Success!!! Contact Details Added</strong>
		</div>";
  }
}
?>
			<div class="app-content">

						<?php include('include/header.php');?>

				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
            <form method="POST" action="addContact.php">
              <?php echo $Msg;
              $database=new Database();
              $database->query('SELECT * FROM settings');
              $database->execute();
              $count=$database->rowCount();
              if($count>0){
                $readOnly="readonly";
                $disabled="disabled";
              }

              ?>
              <fieldset>
                <legend style="border:0px;font-size:30px;"><strong>Please Fill In the Above</strong></legend>
                <div class="row">
                  <div class="col-sm-3">
                    <label for="Subject" class="label-control">School Name</label>&nbsp;<i class="fa fa-university" style="color:red"></i>
                    <input type="text" class="form-control" placeholder="Eg. Munyeki Secondary School" required name="sname" <?php echo $readOnly;?> />
                  </div>
                  <div class="col-sm-3">
                    <label for="Subject" class="label-control">Phone Number</label>&nbsp;<i class="fas fa-phone-alt" style="color:red"></i>
                    <input type="number" class="form-control" required placeholder="Eg.0704922943" name="phone" <?php echo $readOnly;?> />
                  </div>
                  <div class="col-sm-2">
                    <label for="Subject" class="label-control">Office Box</label>&nbsp;<i class="fa fa-cog" style="color:red"></i>
                      <input type="number" class="form-control" required placeholder="Eg.100" name="pbox" <?php echo $readOnly;?> />
                  </div>
                  <div class="col-sm-3">
                    <label for="Subject" class="label-control">Postal Code</label>&nbsp;<i class="fa fa-tag" style="color:red"></i>
                      <input type="text" class="form-control" required placeholder="Eg.20304" name="pcode" <?php echo $readOnly;?> />
                  </div>
                  <div class="col-sm-3">
                    <label for="Subject" class="label-control">City /Town</label>&nbsp;<i class="fas fa-city" style="color:red"></i>
                      <input type="text" class="form-control" required placeholder="Eg.Nakuru" name="pcity" <?php echo $readOnly;?> />
                  </div>
                  <div class="col-sm-3">
                    <label for="Subject" class="label-control">Bank Name</label>&nbsp;<i class="fas fa-city" style="color:red"></i>
                      <input type="text" class="form-control" required placeholder="Eg.Eqiuty" name="bName" <?php echo $readOnly;?> />
                  </div>
                  <div class="col-sm-2">
                    <label for="Subject" class="label-control">Account Number</label>&nbsp;<i class="fas fa-city" style="color:red"></i>
                      <input type="number" class="form-control" required placeholder="Eg.8887094958603" name="aNumber" <?php echo $readOnly;?> />
                  </div>
                  <div class="col-sm-3">
                    <label for="Subject" class="label-control">Receipt Number</label>&nbsp;<i class="fas fa-city" style="color:red"></i>
                      <input type="number" class="form-control" required placeholder="Eg.8887094958603" name="sReceipt" <?php echo $readOnly;?> />
                  </div>
                  <div class="col-sm-2">
                    <br>
                    <button class="badge badge-success fa fa-upload" style="margin-top:10px;" name="sub" <?php echo $disabled;?> >&nbsp;&nbsp;Select Details</button>
                  </div>
                </div>
              </fieldset>
            </form>
					</div>
					<div class="container">
						<?php
						if(isset($_POST['enable'])){
							$db=new Database();
							$db->query('UPDATE settings SET dWatermark=:one');
							$db->bind(':one',1);
							$db->execute();
						}
						if(isset($_POST['disable'])){
							$db=new Database();
							$db->query('UPDATE settings SET dWatermark=:zero');
							$db->bind(':zero',0);
							$db->execute();
						}
						$db=new Database();
						$stat=$db->checkWatermark();
						if($stat){?>
							<form method="POST" action="addContact.php">
								<input type="submit" name="disable" class="btn btn-danger fa fa-times-circle" value="Disable Watermark on Documents"/>
							</form>
						<?php }else{?>
							<form method="POST" action="addContact.php">
								<input type="submit" name="enable" class="btn btn-success fa fa-check-circle" value="Enable Watermark on Documents"/>
							</form>
						<?php }
						 ?>
					</div>
          <div class="table table-responsive">
            <table class="table table-striped table-codensed table-hover table-bordered">
              <thead class="text-center">
                <tr>
                  <td>School Logo</td>
                  <td>Schol Name</td>
                  <td>Phone Number</td>
                  <td>Office Box</td>
                  <td>Postal Code</td>
                  <td>City</td>
                </tr>
              </thead>
              <tbody>
                <?php
                $database=new Database();
                $results=$database->displayTable(settings);
                foreach ($results as $key) {
                  $status="";
                ?>
                <tr>
									<td><img src="<?php echo "assets/images/".$key->Image;?>" width="30px" height="30px" style="border-radius:25px"></td>
                  <td><?php echo $key->sName;?></td>
                  <td><?php echo $key->Phone;?></td>
                  <td><?php echo $key->pBox;?></td>
                  <td><?php echo $key->pCode;?></td>
                  <td><?php echo $key->pCity;?></td>
                  <td><?php 	echo "<a href='editContacts.php?Edit={$key->id}' class='badge badge-primary'><i class='fa fa-edit'>&nbsp;Edit</i></a>";?></td>
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
			});
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
<?php }else{
	header("location: index.php");
}
