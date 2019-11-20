<?php
require_once('Config.php');
class Database{
  private $host=DB_HOST;
  private $user=DB_USER;
  private $password=DB_PASSWORD;
  private $database=DB_NAME;

  private $connection;
  private $error;
  private $stmt;
  private $dbConnected=false;

  public function __construct(){
    //set the pdo data source
    $dsn='mysql:host=' .$this->host . ';dbname=' . $this->database;
    $options=array(
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION
    );
    try{
      $this->connection=new PDO($dsn, $this->user, $this->password,$options);
      $this->dbConnected=true;
    }catch(PDOException $e){
      $this->error=$e->getMessage().PHP_EOL;
    }

  }
  public function isConnected(){
    return $this->dbConnected;
  }
  public function getError(){
    return $this->error;
  }

  public function query($sql){
    $this->stmt= $this->connection->prepare($sql);
  }
  public function execute(){
    return $this->stmt->execute();
  }
  public function resultSet(){
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }
  public function rowCount(){
    return $this->stmt->rowCount();
  }
  public function single(){
    $this->stmt->execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }
  public function count($table){
    //counts the records from a given table
    $this->query('SELECT * FROM '.$table);
    $this->execute();
    $num=$this->rowCount();
    return $num;
  }
  public function single1(){
    $this->stmt->execute();
    return $this->stmt->fetch(PDO::FETCH_ASSOC);
  }
  public function fetchColumn(){
    return $this->stmt->fetchColumn();
  }
  public function bind($param,$value,$type=null){
    if(is_null($type)){
      switch(true){
        case is_int($value):
          $type=PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type=PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type=PDO::PARAM_NULL;
          break;
        default:
          $type=PDO::PARAM_STR;
      }
    }
  $this->stmt->bindValue($param,$value,$type);
}
public function insert($data,$table,$field){
  $this->query("INSERT INTO ".$table."(".$field.")VALUES(:data)");
  $this->bind(':data',$data);
  if($this->execute()){
    return true;
  }
  else{
    return $this->getError();
  }
}
public function update($table,$field,$data,$id){
  $this->query("UPDATE ".$table." SET ".$field."=:designation WHERE empNumber=:empNumber");
  $this->bind(':designation',$data);
  $this->bind(':empNumber',$id);
  if($this->execute()){
    return true;
  }
  else{
    return $this->getError();
  }
}
public function getReg($id){
 $this->query("SELECT studentReg FROM payments WHERE id=:id");
 $this->bind(':id',$id);
 $this->execute();
 return $this->fetchColumn();
}
public function getRegNumber($id){
 $this->query("SELECT studentReg FROM examresults WHERE id=:id");
 $this->bind(':id',$id);
 $this->execute();
 return $this->fetchColumn();
}
public function getName($reg){
 $this->query("SELECT names FROM student WHERE regNo=:regNo");
 $this->bind(':regNo',$reg);
 $this->execute();
 return $this->fetchColumn();
}
public function getSex($reg){
  $this->query("SELECT gender FROM student WHERE regNo=:regNo");
  $this->bind(':regNo',$reg);
  $this->execute();
  return $this->fetchColumn();
 }
 public function getKcpe($reg){
  $this->query("SELECT KCPE FROM student WHERE regNo=:regNo");
  $this->bind(':regNo',$reg);
  $this->execute();
  return $this->fetchColumn();
 }
public function getClass($reg){
 $this->query("SELECT class FROM student WHERE regNo=:regNo");
 $this->bind(':regNo',$reg);
 $this->execute();
 return $this->fetchColumn();
}
public function getGrade($category,$marks){
  if($marks=="--"){
    return "--";

  }else{
    $this->query("SELECT Notation FROM grades WHERE Min<=:Max AND Max>=:min AND subCat=:category");
    $this->bind(':min',$marks);
    $this->bind(':Max',$marks+1);
    $this->bind(':category',$category);
    $this->execute();
    $status=$this->fetchColumn();
    return $status;
  }
}
public function getGradeCount($subject,$class,$exam,$term,$year,$grade,$stream){
  $this->query("SELECT * FROM examresults where Class=:class AND subject=:subject AND  term=:term and Year=:year AND exam=:exam AND Stream=:stream AND grade=:grade");
  $this->bind(':class',$class);
  $this->bind(':subject',$subject);
  $this->bind(':term',$term);
  $this->bind(':year',$year);
  $this->bind(':exam',$exam);
  $this->bind(':stream',$stream);
  $this->bind(':grade',$grade);
  $this->execute();
  $ct=$this->rowCount();
  if($ct==0){
    return 0;
  }else{
    $this->getPoint($ct);
  }
  return $ct;
}
public function getOverallCount($subject,$class,$exam,$term,$year,$grade){
  $this->query("SELECT * FROM examresults where Class=:class AND subject=:subject AND  term=:term and Year=:year AND exam=:exam AND grade=:grade");
  $this->bind(':class',$class);
  $this->bind(':subject',$subject);
  $this->bind(':term',$term);
  $this->bind(':year',$year);
  $this->bind(':exam',$exam);
  $this->bind(':grade',$grade);
  $this->execute();
  $ct=$this->rowCount();
  return $ct;
}
public function getStreamTotals($subject,$class,$exam,$term,$year,$stream){
  $this->query("SELECT * FROM examresults where Class=:class AND subject=:subject AND  term=:term and Year=:year AND exam=:exam AND Stream=:stream");
  $this->bind(':class',$class);
  $this->bind(':subject',$subject);
  $this->bind(':term',$term);
  $this->bind(':year',$year);
  $this->bind(':exam',$exam);
  $this->bind(':stream',$stream);
  $ct=$this->resultSet();
  $totalPts=0;
  foreach($ct as $c){
    $totalPts=$totalPts+$this->getPoint($c->grade);
  }
  return $totalPts;
}
public function getClassTotals($subject,$class,$exam,$term,$year){
  $this->query("SELECT * FROM examresults where Class=:class AND subject=:subject AND  term=:term and Year=:year AND exam=:exam");
  $this->bind(':class',$class);
  $this->bind(':subject',$subject);
  $this->bind(':term',$term);
  $this->bind(':year',$year);
  $this->bind(':exam',$exam);
  $ct=$this->resultSet();
  $totalPts=0;
  foreach($ct as $c){
    $totalPts=$totalPts+$this->getPoint($c->grade);
  }
  return $totalPts;
}
public function getClasstest($class){
 $this->query("SELECT * FROM student WHERE class=:class");
 $this->bind(':class',$class);
 $results=$this->resultSet();
 return $results;
}
//get the subject position in the class using the subject
public function getSubjectPosition($subject,$marks,$class,$term,$year,$exam){
 //$this->query("SELECT count(id) FROM examresults WHERE subject=:subject AND marks>=:marks AND Class=:class");
 $this->query("SELECT * FROM examresults where Class=:class AND subject=:subject and marks>:marks and term=:term and Year=:year AND exam=:exam");
 $this->bind(':class',$class);
 $this->bind(':subject',$subject);
 $this->bind(':marks',$marks);
 $this->bind(':term',$term);
 $this->bind(':year',$year);
 $this->bind(':exam',$exam);
 $this->execute();
 $results=$this->rowCount();
//  echo $_SESSION['exam'],$_SESSION['student'],$_SESSION['class'],$_SESSION['year'];
if($results==0){
 $pos=1;
}else{
$pos=$results;
}
return $pos;
}
//count the total candidates in a class
public function getCount($class){
 $this->query("SELECT count(id) FROM examresults where class=:class");
 $this->bind(':class',$class);
$this->execute();
$count=$this->rowCount();
 return $count;
}
//get the results from the exam results table
function displayResults($studentReg,$exam,$year,$term,$subject){
  $this->query("SELECT marks FROM examresults WHERE studentReg=:studentReg AND exam=:exam AND Year=:year AND term=:term AND subject=:subject");
  $this->bind(':studentReg',$studentReg);
  $this->bind(':exam',$exam);
  $this->bind(':year',$year);
  $this->bind(':term',$term);
  $this->bind(':subject',$subject);
  $this->execute();
  $status=$this->fetchColumn();
  return $status;
}
function displayGrade($studentReg,$exam,$year,$term){
  $this->query("SELECT Grade FROM examtotals WHERE studentReg=:studentReg AND exam=:exam AND year=:year AND term=:term");
  $this->bind(':studentReg',$studentReg);
  $this->bind(':exam',$exam);
  $this->bind(':year',$year);
  $this->bind(':term',$term);
  $this->execute();
  $status=$this->fetchColumn();
  return $status;
}
function displayPoints($studentReg,$exam,$year,$term){
  $this->query("SELECT points FROM examtotals WHERE studentReg=:studentReg AND exam=:exam AND year=:year AND term=:term");
  $this->bind(':studentReg',$studentReg);
  $this->bind(':exam',$exam);
  $this->bind(':year',$year);
  $this->bind(':term',$term);
  $this->execute();
  $status=$this->fetchColumn();
  return $status;
}
function displayCat1($studentReg,$exam,$year,$term,$subject){
  $this->query("SELECT marks FROM catresults WHERE studentReg=:studentReg AND exam=:exam AND Year=:year AND term=:term AND subject=:subject");
  $this->bind(':studentReg',$studentReg);
  $this->bind(':exam',$exam);
  $this->bind(':year',$year);
  $this->bind(':term',$term);
  $this->bind(':subject',$subject);
  $this->execute();
  $status=$this->fetchColumn();
  if($status==0){
    return "--";
  }else{
    return $status;
  }
}
function checkExam($exam,$class,$year,$term){
  $this->query("SELECT * FROM eresults WHERE  exam=:exam AND class=:class AND year=:year AND term=:term");
  $this->bind(':exam',$exam);
  $this->bind(':class',$class);
  $this->bind(':year',$year);
  $this->bind(':term',$term);
  $this->execute();
  $status=$this->rowCount();
  return $status;
}
function checkAverageExam($exam,$class,$year,$term){
  $this->query("SELECT * FROM isavposted WHERE  exam=:exam AND class=:class AND year=:year AND term=:term");
  $this->bind(':exam',$exam);
  $this->bind(':class',$class);
  $this->bind(':year',$year);
  $this->bind(':term',$term);
  $this->execute();
  $status=$this->rowCount();
  return $status;
}
function displayCat2($studentReg,$exam,$year,$term,$subject){
  $this->query("SELECT marks FROM catresults WHERE studentReg=:studentReg AND exam=:exam AND Year=:year AND term=:term AND subject=:subject");
  $this->bind(':studentReg',$studentReg);
  $this->bind(':exam',$exam);
  $this->bind(':year',$year);
  $this->bind(':term',$term);
  $this->bind(':subject',$subject);
  $this->execute();
  $status=$this->fetchColumn();
  if($status==0){
    return "--";
  }else{
    return $status;
  }
}
function displayCatResults($studentReg,$exam,$year,$term){
  $this->query("SELECT * FROM examresults WHERE studentReg=:studentReg AND exam=:exam AND Year=:year AND term=:term");
  $this->bind(':studentReg',$studentReg);
  $this->bind(':exam',$exam);
  $this->bind(':year',$year);
  $this->bind(':term',$term);
  $status=$this->resultSet();
  return $status;
}
public function addAverage($exam,$term,$class,$stream,$year,$reg,$subject,$mark,$grade){
  $this->query('INSERT INTO averageresults(exam,term,Class,Stream,Year,studentReg,subject,marks,grade) VALUES(:exam,:term,:class,:stream,:year,:regNo,:subject,:mark,:grade)');
  $this->bind(':exam',$exam);
  $this->bind(':term',$term);
  $this->bind(':class',$class);
  $this->bind(':stream',$stream);
  $this->bind(':year',$year);
  $this->bind(':regNo',$reg);
  $this->bind(':subject',$subject);
  $this->bind(':mark',$mark);
  $this->bind(':grade',$grade);
  $this->execute();

}
public function getStream($reg){
 $this->query("SELECT stream FROM student WHERE regNo=:regNo");
 $this->bind(':regNo',$reg);
 $this->execute();
 return $this->fetchColumn();
}
public function getTeacher($class,$stream,$subject){
 $this->query("SELECT teacherName FROM subjectteachers WHERE class=:class and stream=:stream and subject=:subject");
 $this->bind(':class',$class);
 $this->bind(':stream',$stream);
 $this->bind(':subject',$subject);
 $this->execute();
 $name=$this->fetchColumn();
 $this->query("SELECT Initial FROM teacher WHERE names=:name");
 $this->bind(':name',$name);
 $this->execute();
 return $this->fetchColumn();
}
public function getParent($reg){
 $this->query("SELECT parent FROM student WHERE regNo=:regNo");
 $this->bind(':regNo',$reg);
 $this->execute();
 return $this->fetchColumn();
}
public function getSchool(){
 $this->query("SELECT * FROM settings");
 $details=$this->resultSet();
  return $details;
}
public function getPayment($id){
  $this->query("SELECT Amount FROM payments WHERE id=:id");
  $this->bind(':id',$id);
  $results=$this->fetchColumn();
  return $results;
}
public function getMean($class,$stream,$term,$year,$exam){
  $this->query('SELECT total FROM classmeans WHERE  class=:class AND stream=:stream AND term=:term AND year=:year AND exam=:exam');
  $this->bind(':class',$class);
  $this->bind(':stream',$stream);
  $this->bind(':term',$term);
  $this->bind(':year',$year);
  $this->bind(':exam',$exam);
  $this->execute();
  $mean=$this->fetchColumn();
  return $mean;

}
public function updateBalance($reg,$bal){
  $this->query("UPDATE student SET balance=:balance WHERE  regNo=:regNo");
  $this->bind(':balance',$bal);
  $this->bind(':regNo',$reg);
  $this->execute();
}
public function updateClassBalance($class,$value){
  $this->query("SELECT * FROM student WHERE class=:class");
  $this->bind(':class',$class);
  $balances=$this->resultSet();
  foreach($balances as $key){
    $balance=$key->balance;
    $newBalance=$balance+$value;
    $this->updateBalance($key->regNo,$newBalance);
  }

}
public function updateIndBalance($regNo,$value){
  $this->query("SELECT balance FROM student WHERE regNo=:regNo");
  $this->bind(':regNo',$regNo);
  $this->execute();
  $balance=$this->fetchColumn();
  $newBalance=$balance-$value;
  $this->query("UPDATE student SET balance=:balance WHERE regNo=:regNo");
  $this->bind(':balance',$newBalance);
  $this->bind(':regNo',$regNo);
  $this->execute();

}
public function promote($newClass,$oldClass){
  //update student set class='1' where class='4'
  $this->query("UPDATE student SET class=:newClass WHERE class=:oldClass");
  $this->bind(':newClass',$newClass);
  $this->bind(':oldClass',$oldClass);
  if($this->execute()){
    return true;
  }else{
    return false;
  }
}
public function role($table,$field,$data,$id){
  $this->query("UPDATE ".$table." SET ".$field."=:designation WHERE names=:empNumber");
  $this->bind(':designation',$data);
  $this->bind(':empNumber',$id);
  if($this->execute()){
    return true;
  }
  else{
    return $this->getError();
  }
}
public function insertSubject($subjectName,$subjectCode,$catName,$subAbbr){
  $this->query("INSERT INTO subject(subjectName,subjectcode,subjectAbbr,subCategory) VALUES(:SN,:SC,:SA,:SCT)");
  $this->bind(':SN',$subjectName);
  $this->bind(':SC',$subjectCode);
  $this->bind(':SA',$subAbbr);
  $this->bind(':SCT',$catName);
  if($this->execute()){
    return true;
  }else{
    return false;
  }
}
public function displayTable($table){
  $this->query("SELECT * FROM ".$table." ORDER BY id ASC");
  $results=$this->resultSet();
  return $results;
}
public function displayStreamMean($class){
  $this->query("SELECT * FROM classmeans WHERE class=:class ORDER BY id ASC");
  $this->bind(':class',$class);
  $results=$this->resultSet();
  return $results;
}
public function displaySMean($class,$stream){
  $this->query("SELECT * FROM classmeans WHERE class=:class AND stream=:stream ORDER BY id ASC");
  $this->bind(':class',$class);
  $this->bind(':stream',$stream);
  $results=$this->resultSet();
  return $results;
}
public function createUser($user,$password,$role){
  $this->query('INSERT INTO users(username,password,role) VALUES(:user,:password,:role)');
  $this->bind(':user',$user);
  $this->bind(':password',$password);
  $this->bind(':role',$role);
  $this->execute();
}
function getCategory($subject){
  $this->query("SELECT subcategory FROM subject WHERE subjectName=:subject");
  $this->bind(':subject',$subject);
  $this->execute();
  $name=$this->fetchColumn();
  return $name;
}
public function editTeacher($id){
  $this->query("SELECT * FROM teacher WHERE id=:id");
  $this->bind(':id',$id);
  return $this->stmt->fetch(PDO::FETCH_OBJ);
}
public function getTotal($exam,$regNo,$class,$year,$term){
  $this->query('SELECT  *  FROM examresults WHERE Class=:class AND exam=:exam AND Year=:year  AND Term=:term');
  $this->bind(':exam',$exam);
  $this->bind(':class',$class);
  $this->bind(':year',$year);
  $this->bind(':term',$term);
  $status=$this->resultSet();
  $total=0;
  foreach ($status as $key) {
    $total=$total+$key->marks;
  }
  return $total;
}public function getPoint($grade){
  if($grade=='A'){
    $g=12;
  }elseif ($grade=='A-') {
    $g=11;
  }elseif($grade=='B+'){
    $g=10;
  }elseif($grade=='B'){
    $g=9;
  }elseif ($grade=='B-') {
    $g=8;
  }elseif($grade=='C+'){
    $g=7;
  }elseif ($grade=='C') {
    $g=6;
  }elseif($grade=='C-'){
    $g=5;
  }elseif ($grade=='D+') {
    $g=04;
  }elseif ($grade=='D') {
    $g=03;
  }elseif ($grade=='D-') {
    $g=02;
  }elseif ($grade=='E'){
    $g=01;
  }elseif ($grade=="--") {
  $g="--";
  }
  else{
    $g=0;
  }
  return $g;
}
public function getNextTotal($class,$term){
  $this->query('SELECT  sum(amount)  FROM nexttermfees WHERE class=:class AND term=:term');
  $this->bind(':class',$class);
  $this->bind(':term',$term);
  $this->execute();
  $status=$this->fetchColumn();
  return 10;
}
public function displayFees($class,$term){
  $this->query("SELECT * FROM fees WHERE class=:class AND term=:term AND year=:year");
  $this->bind(':class',$class);
  $this->bind(':term',$term);
  $year=date("Y");
  $this->bind(':year',$year);
  $results=$this->resultSet();
  return $results;
}
public function displaynTFees($class,$term){
  $this->query("SELECT * FROM nexttermfees WHERE class=:class AND term=:term AND year=:year");
  $this->bind(':class',$class);
  $this->bind(':term',$term);
  $year=date("Y");
  $this->bind(':year',$year);
  $results=$this->resultSet();
  return $results;
}
function getPosition($reg,$exam,$class,$term,$year){
  $this->query("SELECT position FROM examtotals WHERE  studentReg=:studentReg AND exam=:exam AND Class=:class AND term=:term AND year=:year");
  $this->bind(':studentReg',$reg);
  $this->bind(':exam',$exam);
  $this->bind(':class',$class);
  $this->bind(':term',$term);
  $this->bind(':year',$year);
  $this->execute();
  $position=$this->fetchColumn();
  if($position==0){
    $pos="--";
  }else{
    $pos=$position;
  }
  return $pos;
}
function getAveragePosition($reg,$exam,$class,$term,$year){
  $this->query("SELECT position FROM averagetotals WHERE  studentReg=:studentReg AND exam=:exam AND Class=:class AND term=:term AND year=:year");
  $this->bind(':studentReg',$reg);
  $this->bind(':exam',$exam);
  $this->bind(':class',$class);
  $this->bind(':term',$term);
  $this->bind(':year',$year);
  $this->execute();
  $position=$this->fetchColumn();
  if($position==0){
    $pos="--";
  }else{
    $pos=$position;
  }
  return $pos;
}
function getCatPosition($reg,$exam,$class,$term,$year){
  $this->query("SELECT position FROM cattotals WHERE  studentReg=:studentReg AND exam=:exam AND Class=:class AND term=:term AND year=:year");
  $this->bind(':studentReg',$reg);
  $this->bind(':exam',$exam);
  $this->bind(':class',$class);
  $this->bind(':term',$term);
  $this->bind(':year',$year);
  $this->execute();
  $position=$this->fetchColumn();
  if($position==0){
    $pos="--";
  }else{
    $pos=$position;
  }
  return $pos;
}
function getCatPoints($class,$exam,$term,$year,$reg){
  $this->query("SELECT points FROM cattotals WHERE  studentReg=:studentReg AND exam=:exam AND Class=:class AND term=:term AND year=:year");
  $this->bind(':studentReg',$reg);
  $this->bind(':exam',$exam);
  $this->bind(':class',$class);
  $this->bind(':term',$term);
  $this->bind(':year',$year);
  $this->execute();
  $position=$this->fetchColumn();
  return $position;
}
function getCatGrade($class,$exam,$term,$year,$reg){
  $this->query("SELECT Grade FROM cattotals WHERE  studentReg=:studentReg AND exam=:exam AND Class=:class AND term=:term AND year=:year");
  $this->bind(':studentReg',$reg);
  $this->bind(':exam',$exam);
  $this->bind(':class',$class);
  $this->bind(':term',$term);
  $this->bind(':year',$year);
  $this->execute();
  $position=$this->fetchColumn();
  return $position;
}
function getStreamPosition($reg,$exam,$class,$stream,$term,$year){
  $this->query("SELECT StreamPosition FROM examtotals WHERE studentReg=:studentReg AND exam=:exam AND Class=:class AND Stream=:stream AND term=:term AND year=:year");
  $this->bind(':studentReg',$reg);
  $this->bind(':exam',$exam);
  $this->bind(':class',$class);
  $this->bind(':stream',$stream);
  $this->bind(':term',$term);
  $this->bind(':year',$year);
  $this->execute();
  $position=$this->fetchColumn();
  if($position==0){
    $pos="--";
  }else{
    $pos=$position;
  }
  return $pos;
}
public function getBalance($reg){
  $this->query("SELECT balance FROM student WHERE regNo=:regNo");
  $this->bind(':regNo',$reg);
  $this->execute();
  $balance=$this->fetchColumn();
  if($balance<=0){
    return "Nil";
  }else{
    return $balance;
  }
}
public function displayEmployee($table,$role){
  $this->query("SELECT * FROM ".$table." WHERE role=:role");
  $this->bind(':role',$role);
  $results=$this->resultSet();
  return $results;
}
public function DeleteFees($table,$id){
  $this->query("DELETE FROM ".$table." WHERE id=:id");
  $this->bind(':id',$id);
  if($this->execute()){
    return true;
  }else{
    return false;
  }
}
public function displaySum($field){
  $this->query("SELECT * FROM fees WHERE class=:class");
  $this->bind(':class',$field);
  $results=$this->resultSet();
  $sum=0;
  foreach ($results as $key) {
      $sum=$key->amount+$sum;
  }
  return $sum;
}
function getCurrentTerm(){
  $this->query("SELECT currentsession FROM currentsession");
  $this->execute();
  return  $this->fetchColumn();
}
function getNextTerm(){
  $this->query("SELECT term FROM nextsession");
  $this->execute();
  return  $this->fetchColumn();
}
function getOpeningDate(){
  $this->query("SELECT cDate FROM settings");
  $this->execute();
  return  $this->fetchColumn();
}
function checkWatermark(){
  $this->query("SELECT dWatermark FROM settings");
  $this->execute();
  return  $this->fetchColumn();
}function checkCat($exam,$class,$term,$year){
  $this->query("SELECT count(id) FROM catresults WHERE exam=:exam AND class=:class AND term=:term AND Year=:year");
  $this->bind(':exam',$exam);
  $this->bind(':class',$class);
  $this->bind(':term',$term);
  $this->bind(':year',$year);
  $this->execute();
  $stat=$this->fetchColumn();
  return $stat;
}
function getStartReceipt(){
  $this->query("SELECT sReceipt FROM settings");
  $this->execute();
  return  $this->fetchColumn();
}
function getReceiptNumber($id){
  $this->query("SELECT receiptNumber FROM payments WHERE id=:id");
  $this->bind(':id',$id);
  $this->execute();
  return  $this->fetchColumn();
}
public function selectFees($class){
  $this->query("SELECT * FROM fees WHERE class=:class");
  $this->bind(':class',$class);
  $result=$this->execute();
  return $result;
}
public function displayClass($class,$stream){
  $this->query("SELECT * FROM student WHERE class=:class AND stream=:stream AND status=:status");
  $this->bind(':class',$class);
  $this->bind(':stream',$stream);
  $this->bind(':status',1);
  $results=$this->resultSet();
  return $results;
}
public function displayApproved($table){
  $this->query("SELECT * FROM ".$table." WHERE status=:STAT");
  $this->bind(':STAT',1);
  $results=$this->resultSet();
  return $results;
}
public function displayParent($table){
  $this->query("SELECT * FROM ".$table." WHERE role=:STAT");
  $this->bind(':STAT','Parent');
  $results=$this->resultSet();
  return $results;
}
public function displayroledParent($table){
  $this->query("SELECT * FROM ".$table." WHERE  role=:STAT AND roled=:roled");
  $this->bind(':STAT','Parent');
  $this->bind(':roled',1);
  $results=$this->resultSet();
  return $results;
}
public function activate($table,$col,$id){
  $this->query("UPDATE ".$table." SET ".$col." =1 WHERE id=:id");
  $this->bind(':id',$id);
  if($this->execute()){
    return true;
  }else{
    return false;
  }
}
public function deactivate($table,$col,$id){
  $this->query("UPDATE ".$table." SET ".$col." =0 WHERE id=:id");
  $this->bind(':id',$id);
  if($this->execute()){
    return true;
  }else{
    return false;
  }
}
public function getMarks($subject,$class,$exam,$year,$reg){
  $this->query("SELECT marks FROM examresults WHERE Class=:class AND Subject=:subject AND exam=:exam AND Year=:year AND studentReg=:regNo");
  $this->bind(':class',$class);
  $this->bind(':subject',$subject);
  $this->bind(':exam',$exam);
  $this->bind(':year',$year);
  $this->bind(':regNo',$reg);
  $this->execute();
  $marks=$this->fetchColumn();
  if(!$marks){
    $mark="--";
  }else{
    $mark=$marks;
  }
return $mark;
}
public function getAverageMarks($subject,$class,$exam,$year,$reg){
  $this->query("SELECT marks FROM averageresults WHERE Class=:class AND Subject=:subject AND exam=:exam AND Year=:year AND studentReg=:regNo");
  $this->bind(':class',$class);
  $this->bind(':subject',$subject);
  $this->bind(':exam',$exam);
  $this->bind(':year',$year);
  $this->bind(':regNo',$reg);
  $this->execute();
  $marks=$this->fetchColumn();
  if(!$marks){
    $mark="--";
  }else{
    $mark=$marks;
  }
return $mark;
}
public function getCatMarks($subject,$class,$exam,$year,$reg){
  $this->query("SELECT marks FROM catresults WHERE Class=:class AND subject=:subject AND exam=:exam AND Year=:year AND studentReg=:regNo");
  $this->bind(':class',$class);
  $this->bind(':subject',$subject);
  $this->bind(':exam',$exam);
  $this->bind(':year',$year);
  $this->bind(':regNo',$reg);
  $this->execute();
  $marks=$this->fetchColumn();
  if(!$marks){
    $mark="--";
  }else{
    $mark=$marks;
  }
return $mark;
}
public function getsMarks($subject,$class,$stream,$exam,$year,$reg){
  $this->query("SELECT marks FROM examresults WHERE Class=:class AND Stream=:stream AND Subject=:subject AND exam=:exam AND Year=:year AND studentReg=:regNo");
  $this->bind(':class',$class);
  $this->bind(':stream',$stream);
  $this->bind(':subject',$subject);
  $this->bind(':exam',$exam);
  $this->bind(':year',$year);
  $this->bind(':regNo',$reg);
  $this->execute();
  $marks=$this->fetchColumn();
  if(!$marks){
    $mark="--";
  }else{
    $mark=$marks;
  }
return $mark;
}
public function getSubjectGrade($subject,$class,$exam,$year,$reg){
  $this->query("SELECT grade FROM examresults WHERE Class=:class AND Subject=:subject AND exam=:exam AND Year=:year AND studentReg=:regNo");
  $this->bind(':class',$class);
  $this->bind(':subject',$subject);
  $this->bind(':exam',$exam);
  $this->bind(':year',$year);
  $this->bind(':regNo',$reg);
  $this->execute();
  $grade=$this->fetchColumn();
  if(!$grade){
    $grade="--";
  }else{
    $grade=$grade;
  }
return $grade;
}
public function getCatSubjectGrade($subject,$class,$exam,$year,$reg){
  $this->query("SELECT grade FROM catresults WHERE Class=:class AND Subject=:subject AND exam=:exam AND Year=:year AND studentReg=:regNo");
  $this->bind(':class',$class);
  $this->bind(':subject',$subject);
  $this->bind(':exam',$exam);
  $this->bind(':year',$year);
  $this->bind(':regNo',$reg);
  $this->execute();
  $grade=$this->fetchColumn();
  if(!$grade){
    $grade="--";
  }else{
    $grade=$grade;
  }
return $grade;
}

public function delete($table,$id){
  $this->query("DELETE FROM ".$table." WHERE id=:id");
  $this->bind(':id',$id);
  if($this->execute()){
    return true;
  }else{
    return false;
  }
}
}
