<?php
session_start();
if(isset($_SESSION['role'])){
  $_SESSION['class']=$_GET['Class'];
  $_SESSION['term']=$_GET['Term'];
  $_SESSION['year']=$_GET['Year'];
  $_SESSION['exam']=$_GET['Exam'];
  require_once('Database.php');
  $db=new Database();
	include('include/fpdf.php');
	class myClass extends FPDF{
    public $angle;
    public function Header(){
      $database=new Database();
      $details=$database->getSchool();
      foreach ($details as $key) {
        $this->SetFont('Arial','B','90');
        if($database->checkWatermark()){
          $this->watermark($key->sName,26,11);
        }else{
          continue;
        }
        $this->SetFont('Arial','B','10');
      }

    }
    function watermark($text,$angle,$start){
      $this->SetTextColor(255,200,233);
      $this->Rotate($angle,20,200);
      $this->Text($start,190,$text);
      $this->Rotate(0);
    }
    function Rotate($angle,$x=-1,$y=-1)
    {
      if($x==-1)
        $x=$this->x;
      if($y==-1)
        $y=$this->y;
      if($this->angle!=0)
        $this->_out('Q');
      $this->angle=$angle;
      if($angle!=0)
      {
        $angle*=M_PI/180;
        $c=cos($angle);
        $s=sin($angle);
        $cx=$x*$this->k;
        $cy=($this->h-$y)*$this->k;
        $this->_out(sprintf('q %.2F %.2F %.2F %.2F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
      }
    }
    function _endpage()
    {
      if($this->angle!=0)
      {
        $this->angle=0;
        $this->_out('Q');
      }
      parent::_endpage();
    }
		function head($db,$class,$stream){
			$this->SetFont('Arial','',12);
      //$this->SetFont('Arial','',10);
      $detail=$db->getSchool();
      foreach($detail as $key){
				$this->Image('assets/images/'.$key->Image,40,10,0,25);
				$this->SetFont('Courier','B','30');
				$this->Cell(440,20,$key->sName,0,0,'C');
        $this->Ln(15);
        $this->SetFont('Courier','B','15');
				$this->Cell(440,5,"Tel :".$key->Phone,0,0,'C');
        $this->Ln();
        $this->SetFont('Courier','B','15');
				$this->Cell(440,5,"P.O.Box ".$key->pBox." ".$key->pCode." ".$key->pCity." Kenya",0,0,'C');
				$this->Ln(8);
        $this->SetFont('Arial','B','15');
				$this->Cell(440,5,"Form ".$class." ".$_SESSION['stream']." Students",0,0,'C');
				$this->Ln(8);
        $this->Cell(440,5,$_SESSION['exam']." Exam Results",0,0,'C');
        $this->Ln(10);
      }
		}
		function footer(){
			$this->SetY(-15);
			$this->SetFont('Arial','','10');
      $this->Cell(0,10,'=======================================================================================',0,0);
      $this->Ln(3);
			$this->Cell(0,10,'The School holds the right to edit the contents of this Document when necessary',0,0);
			$this->SetX(-40);
      $this->Ln();
      $this->SetTextColor(125,125,125);
			$this->Cell(0,0,'Generated By '.$_SESSION['role'],0,0);
		}
		function headerTable(){
			$this->SetFont('courier','',12);
			$this->Cell(22,5,'Position',1,0,'C');
			$this->Cell(15,5,'Reg',1,0,'C');
			$this->Cell(80,5,'Names',1,0,'C');
			$this->Cell(20,5,'Stream',1,0,'C');
      $database=new Database();
      $database->query("SELECT * FROM subject WHERE status=:status");
      $database->bind(':status',1);
      $subject=$database->resultSet();
      foreach ($subject as $key) {
       $this->Cell(18,5,$key->subjectAbbr,1,0,'C');
      }
        $this->Cell(15,5,'Grade',1,0,'C');
        $this->Cell(22,5,'Subjects',1,0,'C');
        $this->Cell(20,5,'Totals',1,0,'C');
			$this->Ln();
		}
		function viewTable($db){
			$this->SetFont('Arial','',8);
      $db->query("SELECT * FROM examTotals WHERE Class=:class AND Stream=:stream ORDER BY StreamPosition ASC");
      $db->bind(':class',$_SESSION['class']);
      $db->bind(':stream',$_SESSION['stream']);
      $results=$db->resultSet();
      $total=0;
      $count=1;
      $cmean=0;
      foreach ($results as $data) {
        $this->SetFont('courier','I',12);
				$this->Cell(22,5,$data->position,1,0,'C');
				$this->Cell(15,5,$data->studentReg,1,0,'C');
        $cmean=$cmean+$data->points;
        $this->SetFont('courier','I',12);
        $db=new Database();
				$this->Cell(80,5,$db->getName($data->studentReg),1,0,'L');
				$this->Cell(20,5,$data->Stream,1,0,'L');
        $this->SetFont('courier','I',10);
        $db->query("SELECT * FROM subject WHERE status=:status");
        $db->bind(':status',1);
        $subject=$db->resultSet();
        $marks=0;
        $count=0;
        foreach ($subject as $key) {
        $mark=$db->getsMarks($key->subjectName,$_SESSION['class'],$_SESSION['stream'],$_SESSION['exam'],$_SESSION['year'],$data->studentReg);
        if($mark=="--"){
          $this->Cell(18,5,$mark,1,0,'L');
        }else{
          $db=new Database();
          $category=$db->getCategory($key->subjectName);
          $grade=$db->getGrade($category,$mark);
          if($mark<10 && $mark>0){
            $this->Cell(18,5,"0".$mark." ".$grade,1,0,'L');
          }else{
              $this->Cell(18,5,$mark." ".$grade,1,0,'L');
          }
          $count=$count+1;
        }
        }
        if($count==0){
          $mean= round($data->total);
        }else{
          $mean=round($data->total/$count);
        }

        // $abs=$mean/100;
        // $grade=round($abs*12);
        if($mean>=80){
          $g="A";
        }
        elseif ($mean>=75 && $mean<=79) {
          $g='A-';
        }
        elseif ($mean>=70 && $mean<=74) {
          $g='B+';
        }
        elseif($mean>=65 && $mean<=69){
          $g='B';
        }elseif($mean>=60 && $mean<=64){
          $g='B-';
        }elseif ($mean>=55 && $mean<=59) {
          $g='C+';
        }elseif($mean>=50 && $mean<=54){
          $g='C';
        }elseif ($mean>=45 && $mean<=49) {
          $g='C-';
        }elseif($mean>=40 && $mean<=44){
          $g='D+';
        }elseif ($mean>=35 && $mean<=39) {
          $g='D';
        }elseif ($mean>=30 && $mean<=34) {
          $g='D-';
        }elseif ($mean>=01 && $mean<=29) {
          $g='E';
        }else{
          $g='-';
      }
          $this->Cell(15,5,$g,1,0,'C');
          $this->Cell(22,5,$count,1,0,'C');
          $this->Cell(20,5,$data->total,1,0,'C');
        $this->Ln();
        $total=$total+1;
        $count=$count+1;
			}
      	$this->SetFont('Arial','IB',13);
        $this->Cell(440,10,"MEAN ",0,0,'C');
        	$this->SetFont('courier','B',8);
      	$this->Ln();
        $this->SetLeftMargin(180);
        $this->Cell(50,5,"Stream ",1,0,'C');
        $this->Cell(50,5,"Mean",1,0,'C');
        $this->Ln();
        $this->SetLeftMargin(180);
        $db=new Database();
        $means=$db->displaySMean($_SESSION['class'],$_SESSION['stream']);
        foreach ($means as $mean ) {
          $mm=($mean->total/100)*12;
          if(round($mm)==12){
            $g="A";
          }
          elseif (round($mm)==11) {
            $g='A-';
          }
          elseif (round($mm)==10) {
            $g='B+';
          }
          elseif(round($mm)==9){
            $g='B';
          }elseif(round($mm)==8){
            $g='B-';
          }elseif (round($mm)==7) {
            $g='C+';
          }elseif(round($mm)==6){
            $g='C';
          }elseif (round($mm)==5) {
            $g='C-';
          }elseif(round($mm)==4){
            $g='D+';
          }elseif (round($mm)==3) {
            $g='D';
          }elseif (round($mm)==2) {
            $g='D-';
          }elseif (round($mm)==1) {
            $g='E';
          }else{
            $g='-';
        }
          $this->Cell(50,5,$mean->stream,1,0,'C');
        $this->Cell(50,5,number_format($mm, 4)." ".$g,1,0,'C');
        $this->Ln();
        }
        $this->SetLeftMargin(100);
      $this->SetTextColor(0,0,0);
		}
	}
	$pdf=new myClass();
	$pdf->AliasNbPages();
	  $pdf->AddPage('l','A3',0);
	$pdf->head($db,$_SESSION['class'],$_SESSION['stream']);
	$pdf->headerTable();
	$pdf->viewTable($db);
	$pdf->output();
}else{  header("Location: index.php");}
?>
