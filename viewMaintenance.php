Maintenance<?php
session_start();
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
?>
			<div class="app-content">

						<?php include('include/header.php');?>
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
            View Miscelanoeus Amounts
						<?php
						if(isset($_GET['Activate'])){
							$id=$_GET['Activate'];
							$db=new Database();
							$db->query("UPDATE maintenance SET status=:status, DateA=:DateA WHERE id=:id");
							$db->bind(':status',1);
							$db->bind(':DateA',date("Y-M-d"));
							$db->bind(':id',$id);
							$status=$db->execute();
							if($status){
								echo "<div class='alert alert-success'id='alert'>
									<strong>Miscelaneous Amount Approved!!</strong>
								</div>";
							}
						}
						if(isset($_GET['Deactivate'])){
							$id=$_GET['Deactivate'];
							$db=new Database();
							$status=$db->deactivate('maintenance','status',$id);
							if($status){
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Miscelaneous Amount Rejected!!</strong>
								</div>";
							}else{
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Error!! Unknown Error Occurred</strong>
								</div>";
							}
						}
						if(isset($_GET['Delete'])){
							$id=$_GET['Delete'];
							$db=new Database();
							$delete=$db->delete('club',$id);
							if($delete){
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Club deleted!!</strong>
								</div>";
							}else{
								echo "<div class='alert alert-danger'id='alert'>
									<strong>Club Not Deleted!!</strong>
								</div>";
							}
						}
						?>
            <div class="table table-responsive" style="font-family:courier">
    					<table class="table table-striped table-codensed table-hover table-bordered">
    						<thead class="text-center">
    							<tr>
    								<td>Date Requested</td>
    								<td>About</td>
    								<td>Amount</td>
    								<td>Status</td>
										<td colspan="2">Action</td>
    							</tr>
    						</thead>
    						<tbody>
									<?php
									$database=new Database();
									$results=$database->displayTable(maintenance);
									$count=$database->rowCount();
									if($count==0){
										echo "<div class='alert alert-danger'id='alert'>
											<strong>No Miscellaneous Amount Requested!!</strong>
										</div>";
									}else{
									foreach ($results as $key) {
										$status="";
									?>
									<tr>
										<td style="font-size:10px"><?php echo $key->Dater;?></td>
										<td style="font-size:10px"><?php echo $key->Descr;?></td>
										<td style="font-size:10px"><?php echo $key->Amount;?></td>
										<td style="font-size:8px;font-weight:bolder"><?php
										if($key->status==1){
											$status=1;
											echo "<span style='color:green;'>Approved On ".$key->DateA."</span>";
										}else{
											$status=0;
												echo "<span style='color:red;'>Pending Approval</span>";
										}
										?></td>
										<td style="font-size:10px"><?php
										if($status==1){
											echo "<a href='viewMaintenance.php?Deactivate={$key->id}' class='badge badge-warning' style='background-color:yellow;color:blue'><i class='fa fa-times'>&nbsp;Reject</i></a>";
										}else{
											echo "<a href='viewMaintenance.php?Activate={$key->id}' class='badge badge-success'><i class='fa fa-check'>&nbsp;Approve</i></a>";
										}
										?></td>
										<td><?php 	echo "<a href='viewClubs.php?Delete={$key->id}' class='badge badge-danger'><i class='fa fa-times-circle'>&nbsp;Delete</i></a>";?></td>
									</tr>
								<?php }}?>
    						 </tbody>
    					 </table>
							 <?php
							 //Update the balances using the latest school fees
							 //get the total school fees
		           $db=new Database();

		           ?>
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
