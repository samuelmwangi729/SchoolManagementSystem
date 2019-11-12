<?php
error_reporting(0);
require_once('Database.php');
$db=new Database();
$db->query('SELECT *  FROM catresults ');
$results=$db->resultSet();
$id=1;
foreach ($results as $key ) {
	$subcat=$db->getCategory($key->subject);
	$grade=$db->getGrade($subcat,$key->marks);
	$db->query('UPDATE catresults SET grade=:grade WHERE id=:id');
	$db->bind(':grade',$grade);
	$db->bind(':id',$key->id);
	$db->execute();
}
echo "Success,Grades Updated</br><a href='resultsCat.php'>Click Here to continue</a>";
?>
