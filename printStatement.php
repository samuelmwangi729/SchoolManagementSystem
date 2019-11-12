<?php
session_start();
if(isset($_SESSION['role'])){
  require_once('Database.php');
  $db=new Database();
	include('include/fpdf.php');
	class myClass extends FPDF{
    public $angle;
    public function Header(){
      $database=new Database();
      $details=$database->getSchool();
      foreach ($details as $key) {
        $this->SetFont('Arial','B','40');
        if($database->checkWatermark()){
          $this->watermark($key->sName,45,85);
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
		function head($db){
      $detail=$db->getSchool();
      foreach($detail as $key){
			$this->SetFont('Arial','',10);
			//$statement=$db->displayFees($class,$term);
				$this->Image('assets/images/'.$key->Image,20,15,0,20);
				$this->SetFont('Courier','B','20');
				$this->Cell(200,20,$key->sName,0,0,'C');
        $this->Ln(15);
        $this->SetFont('Courier','B','10');
				$this->Cell(200,5,"Tel :".$key->Phone,0,0,'C');
        $this->Ln();
        $this->SetFont('Courier','B','10');
				$this->Cell(200,5,"P.O.Box ".$key->pBox." ".$key->pCode." ".$key->pCity." Kenya",0,0,'C');
				$this->Ln(10);
        $this->SetFont('Arial','B','10');
			$this->Cell(200,5,"Payment Statement as at ".date("D-Y-M-d"),0,0,'C');
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
			$this->SetFont('Arial','B','12');
			$this->Cell(50,5,'Registration Number',1,0,'C');
			$this->Cell(30,5,'Term',1,0,'C');
			$this->Cell(30,5,'Amount',1,0,'C');
			$this->Cell(40,5,'Class',1,0,'C');
			$this->Cell(40,5,'Year',1,0,'C');
			$this->Ln();
		}
		function viewTable($db){
			$this->SetFont('Arial','',10);
			$results=$db->displayTable('payments');
      $total=0;
      foreach ($results as $data) {
				$this->Cell(50,5,$data->studentReg,1,0,'C');
				$this->Cell(30,5,$data->term,1,0,'C');
				$this->Cell(30,5,$data->Amount,1,0,'C');
				$this->Cell(40,5,$data->class,1,0,'C');
				$this->Cell(40,5,$data->Year,1,0,'C');
        $this->Ln();
        $total=$total+1;
			}
      	$this->Ln();
      $this->SetTextColor(0,0,0);
      $this->Cell(100,10,"Total Transactions ",0,0,'C');
      $this->Cell(95,10,"===========",0,0,'C');
      $this->Ln(3);
      $this->Cell(100,10,"",0,0,'C');
      $this->Cell(95,10,$total." Transactions",0,0,'C');
      $this->Ln(3);
      $this->Cell(100,10," ",0,0,'C');
      $this->Cell(95,10,"===========",0,0,'C');
		}
	}
	$pdf=new myClass();
	$pdf->AliasNbPages();
	$pdf->AddPage('p','A4',0);
	$pdf->head($db);
	$pdf->headerTable();
	$pdf->viewTable($db);
	$pdf->output();
}else{  header("Location: index.php");}
?>