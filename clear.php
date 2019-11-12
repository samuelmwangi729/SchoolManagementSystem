<?php
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
}

?>
			<div class="app-content">

						<?php include('include/header.php');?>
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<?php
						if(isset($_GET['truncate'])){
							$table=$_GET['truncate'];
							$db=new Database();
							$query='TRUNCATE TABLE '.$table;
							$db->query($query);
							$db->execute();
						}
						?>
						<div class="table table-responsive" style="margin-top:10px">
							<table class="table table-hover">
								<marquee><span style="color:red;font-size:16px" class="text-center">Please Beware, you can break the whole system. Kindly do this if you know what you are doing.</span></marquee/>
								<tr>
									<td>Table name</td>
									<td>Action</td>
								</tr>
								<?php
								$db=new Database();
								$db->query('SHOW TABLES');
								$tables=$db->resultSet();
								foreach ($tables as $key) {?>
									<tr>
										<td><?php
										if($key->Tables_in_school=="users" || $key->Tables_in_school=="settings"){
											continue;
										}
										 echo $key->Tables_in_school;
										 ?></td>
										<td><?php echo "<a href='clear.php?truncate={$key->Tables_in_school}' class='badge badge-danger'>Clear Data</a>"; ?></td>
									</tr>
								<?php }?>
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
