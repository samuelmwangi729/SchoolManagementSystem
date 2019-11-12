<?php
session_start();
$data=[];
require_once('Database.php');
if(isset($_SESSION['role'])){
  $_SESSION['eClass']=$_POST['class'];
  $_SESSION['eStream']=$_POST['stream'];
  $_SESSION['eTitle']=$_POST['exam'];
  $_SESSION['eSubject']=$_POST['subject'];
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
            <h2 style="color:red;font-weight:bold;margin-top:2px" class="text-center">Form <?php echo $_POST['class']." ".$_POST['stream']." ".$_POST['exam']." ".$_POST['subject'];?> Marks Entry</h2>
            <div class="table table-responsive">
    					<table class="table table-striped" width="300px">
    						<thead class="text-center">
    							<tr>
    								<td>Names</td>
    								<td>Reg Number</td>
										<td>Marks</td>
    							</tr>
    						</thead>
    						<tbody>
                  <form method="POST">
									<?php
                  ob_start();
									$database=new Database();
                  if($_SESSION['eStream']=='All Streams'){
                    $query="SELECT * FROM student WHERE class=:class AND status=:status";
                    $database->query($query);
                    $database->bind(':class',$_SESSION['eClass']);
                  }else{
                    $query="SELECT * FROM student WHERE class=:class AND stream=:stream AND status=:status";
                    $database->query($query);
                    $database->bind(':class',$_SESSION['eClass']);
                    $database->bind(':stream',$_SESSION['eStream']);
                  }
                  $database->bind(':status',1);
									$results=$database->resultSet();
									foreach ($results as $key) {
										$status="";
                    ?>
									<tr style="border:none;">
											<td><?php echo $key->names;?></td>
											<td><?php echo $key->regNo;?></td>
											<td>
                        <input type="hidden" value="<?php echo $_SESSION['eClass'];?>" name="class[]"/>
                        <input type="hidden" value="<?php echo $_SESSION['eStream'];?>" name="stream[]"/>
                        <input type="hidden" value="<?php echo $_SESSION['eTitle'];?>" name="exam[]"/>
                        <input type="hidden" value="<?php echo $_SESSION['eSubject'];?>" name="subject[]"/>
                        <input type="hidden" value="<?php echo $key->regNo;?>" name="reg[]"/>
                        <input type="number" name="arr[]" class="form-control" style="border:none;background-color: inherit;border-bottom:3px solid blue" placeholder="Eg. 75" maxlength="2" title="Enter the marks Here" /></td>
								<?php }
                ?>
                <input type="submit" class="btn btn-success" value="Upload Marks" name="upload"/>
              </form>

    						 </tbody>
                 <?php echo $Msg;?>
    					 </table>
    				</div>
            <table width="285" border="2">
              <span style="color:red"> <?php
            if(isset($_REQUEST['upload'])){
              $class=$_REQUEST['class'];
              $stream=$_REQUEST['stream'];
              $exam=$_REQUEST['exam'];
              $subject=$_REQUEST['subject'];
              $marks=$_REQUEST['arr'];
              $regs=$_REQUEST['reg'];
              $db=new Database();
              $term=$db->getCurrentTerm();
              for ($i=0; $i < count($marks); $i++) {
                $stream=$db->getStream($regs[$i]);
                $db->query("INSERT INTO catresults(exam,term,Class,Stream,Year,studentReg,subject,marks,grade) VALUES(:exam,:term,:class,:stream,:year,:regNo,:subject,:marks,:grade)");
                $db->bind(':exam',$exam[$i]);
                $db->bind(':term',$term);
                $db->bind(':class',$class[$i]);
                $db->bind(':stream',$stream);
                $db->bind(':year',date('Y'));
                $db->bind(':regNo',$regs[$i]);
                $db->bind(':subject',$subject[$i]);
                $datab=new Database();
                $cat=$datab->getCategory($subject[$i]);
                $grade=$datab->getGrade($cat,$marks[$i]);
                $db->bind(':marks',$marks[$i]);
                $db->bind(':grade',$grade);
                $db->execute();
              }

              echo "<script>window.open('manageCats.php','_self');</script>";
            }
            ?></span>
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
