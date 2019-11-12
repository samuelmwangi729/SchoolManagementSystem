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
						<!-- start: PAGE TITLE -->
						<!-- end: PAGE TITLE -->
						<!-- start: BASIC EXAMPLE -->
							<div class="container-fluid container-fullw bg-white">
							<div class="row">
								<div class="col-sm-3">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"><i class="fas fa-user-graduate" style="color:red"></i> </span>
											<h2 class="StepTitle">Students<sup><span class="badge badge-success">
												<?php
												$db=new Database();
												$db->query("SELECT * FROM student WHERE  Class BETWEEN :min AND :max");
												$db->bind(':min',1);
												$db->bind(':max',4);
												$db->execute();
												echo $db->rowCount();
												?>
											</span></sup></h2>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"><i class="fa fa-book" style="color:red"></i> </span>
											<h2 class="StepTitle">Librarians<sup><span class="badge badge-success"><?php
											$db=new Database();
											$db->query("SELECT * FROM teacher WHERE role=:role");
											$db->bind(':role','Librarian');
											$db->execute();
											echo $db->rowCount();
											?></span></sup></h2>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"><i class="fas fa-chalkboard-teacher" style="color:red"></i> </span>
											<h2 class="StepTitle">Teachers<sup><span class="badge badge-success"><?php
											$db=new Database();
											$db->query("SELECT * FROM teacher WHERE role=:role");
											$db->bind(':role','teacher');
											$db->execute();
											echo $db->rowCount();
											?></span></sup></h2>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"><i class="fa fa-calculator" style="color:red"></i> </span>
											<h2 class="StepTitle">Bursars<sup><span class="badge badge-success"><?php
											$db=new Database();
											$db->query("SELECT * FROM teacher WHERE role=:role");
											$db->bind(':role','Accountant');
											$db->execute();
											echo $db->rowCount();
											?></span></sup></h2>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
							<div class="col-sm-3">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"><i class="fas fa-hand-holding-usd" style="color:red"></i> </span>
											<h4 class="StepTitle">Fees Paid<sup><span class="badge badge-success"><?php
											$db=new Database();
											$db->query("SELECT * FROM payments");
											$db->bind(':role','Accountant');
											$tot=$db->resultSet();
											$sum=0;
											foreach($tot as $key) {
												$sum=$sum+$key->Amount;
											}
											echo $sum;
											?></span></sup></h4>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"><i class="fa fa-wrench" style="color:red"></i> </span>
											<h4 class="StepTitle">Expenses<sup><span class="badge badge-success"><?php
											$db=new Database();
											$db->query("SELECT * FROM maintenance");
											$tot=$db->resultSet();
											$sum=0;
											foreach($tot as $key) {
												$sum=$sum+$key->Amount;
											}
											echo $sum;
											?></span></sup></h4>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"><i class="fa fa-chart-line" style="color:red"></i> </span>
											<h4 class="StepTitle">Balances<sup><span class="badge badge-success"><?php
											$db=new Database();
											$db->query("SELECT * FROM student");
											$tot=$db->resultSet();
											$sum=0;
											foreach($tot as $key) {
												$sum=$sum+$key->balance;
											}
											echo $sum;
											?></span></sup></h4>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"><i class="fa fa-users" style="color:red"></i> </span>
											<h4 class="StepTitle">Clubs<sup><span class="badge badge-success"><?php
											$db=new Database();
											$db->query("SELECT * FROM club");
											$db->execute();
											echo $db->rowCount();
											?></span></sup></h4>
										</div>
									</div>
								</div>
							<div class="row">
								<div class="col-sm-6">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"><i class="fa fa-male" style="color:red"></i> </span>
											<h6 class="StepTitle"> Form 1 Boys&nbsp;&nbsp;<sup><span class="badge badge-success"><?php
											$db=new Database();
											$db->query("SELECT * FROM student WHERE gender=:role AND Class=:class");
											$db->bind(':role','M');
											$db->bind(':class','1');
											$db->execute();
											echo $db->rowCount();
											?></span></sup></h6>
											<h6 class="StepTitle">  Form 2 Boys&nbsp;&nbsp;<sup><span class="badge badge-success"><?php
											$db=new Database();
											$db->query("SELECT * FROM student WHERE gender=:role AND Class=:class");
											$db->bind(':role','M');
											$db->bind(':class','2');
											$db->execute();
											echo $db->rowCount();
											?></span></sup></h6>
											<h6 class="StepTitle">Form 3  Boys&nbsp;&nbsp; <sup><span class="badge badge-success"><?php
											$db=new Database();
											$db->query("SELECT * FROM student WHERE gender=:role AND Class=:class");
											$db->bind(':role','M');
											$db->bind(':class','3');
											$db->execute();
											echo $db->rowCount();
											?></span></sup></h6>
											<h6 class="StepTitle"> Form 4 Boys&nbsp;&nbsp; <sup><span class="badge badge-success"><?php
											$db=new Database();
											$db->query("SELECT * FROM student WHERE gender=:role AND Class=:class");
											$db->bind(':role','M');
											$db->bind(':class','4');
											$db->execute();
											echo $db->rowCount();
											?></span></sup></h6>
											<h6 class="StepTitle" style="color:red">Total  Boys &nbsp;&nbsp;<sup><span class="badge badge-danger"><?php
											$db=new Database();
											$db->query("SELECT * FROM student WHERE gender=:role AND Class BETWEEN :min AND :max");
											$db->bind(':role','M');
											$db->bind(':min',1);
											$db->bind(':max',4);
											$db->execute();
											echo $db->rowCount();
											?></span></sup></h6>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="panel panel-white no-radius text-center">
										<div class="panel-body">
											<span class="fa-stack fa-2x"><i class="fa fa-female" style="color:red"></i> </span>
											<h6 class="StepTitle"> Form 1 Girls&nbsp;&nbsp;<sup><span class="badge badge-success"><?php
											$db=new Database();
											$db->query("SELECT * FROM student WHERE gender=:role AND Class=:class");
											$db->bind(':role','F');
											$db->bind(':class',1);
											$db->execute();
											echo $db->rowCount();
											?></span></sup></h6>
											<h6 class="StepTitle">  Form 2 Girls&nbsp;&nbsp;<sup><span class="badge badge-success"><?php
											$db=new Database();
											$db->query("SELECT * FROM student WHERE gender=:role AND Class=:class");
											$db->bind(':role','F');
											$db->bind(':class',2);
											$db->execute();
											echo $db->rowCount();
											?></span></sup></h6>
											<h6 class="StepTitle">Form 3 Girls&nbsp;&nbsp;<sup><span class="badge badge-success"><?php
											$db=new Database();
											$db->query("SELECT * FROM student WHERE gender=:role AND Class=:class");
											$db->bind(':role','F');
											$db->bind(':class',3);
											$db->execute();
											echo $db->rowCount();
											?></span></sup></h6>
											<h6 class="StepTitle"> Form 4 Girls&nbsp;&nbsp;<sup><span class="badge badge-success"><?php
											$db=new Database();
											$db->query("SELECT * FROM student WHERE gender=:role AND Class=:class");
											$db->bind(':role','F');
											$db->bind(':class',4);
											$db->execute();
											echo $db->rowCount();
											?></span></sup></h6>
											<h6 class="StepTitle" style="color:red">Total  Girls&nbsp;&nbsp;<sup><span class="badge badge-danger"><?php
											$db=new Database();
											$db->query("SELECT * FROM student WHERE gender=:role");
											$db->bind(':role','F');
											$db->execute();
											echo $db->rowCount();
											?></span></sup></h6>
										</div>
									</div>
								</div>
							</div>
							</div>
						</div>
						<!-- end: SELECT BOXES --><br>
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
			var config = {
				type: 'line',
				data: {
					labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
					datasets: [{
						label: 'Form 1',
						fill: false,
						borderColor: window.chartColors.red,
						backgroundColor: window.chartColors.red,
						data: [
							100,14,5,32,89,54,15,90,31,9
						]
					}, {
						label: 'Form 2',
						fill: false,
						borderColor: window.chartColors.blue,
						backgroundColor: window.chartColors.blue,
						data: [
							12,34,10,76,32,9,76,90,4,10
						]
					},{
						label: 'Form 3',
						fill: false,
						borderColor: window.chartColors.purple,
						backgroundColor: window.chartColors.purple,
						data: [
							10,24,10,7,45,29,46,9,40,100
						]
					},{
						label: 'Form 4',
						fill: false,
						borderColor: window.chartColors.green,
						backgroundColor: window.chartColors.green,
						data: [
							8,43,00,67,23,19,56,29,74,80
						]
					}]
				}
			};

			window.onload = function() {
				var ctx = document.getElementById('canvas').getContext('2d');
				window.myLine = new Chart(ctx, config);
			};
		</script>
		<!-- end: JavaScript Event Handlers for this page -->
		<!-- end: CLIP-TWO JAVASCRIPTS -->
	</body>
</html>
<?php }else{
	header("location: index.php");
}
