<?php
require_once('Database.php');
/**
 *
 */
interface ValidateInterface
{
  public function encrypt($password);
  public function sanitize($username);
  public function getRole($username);
}
class Validate implements ValidateInterface{
  public function encrypt($password){
    return sha1($password);
  }

  /*
  *to clean the username
  */
  public function sanitize($username){

    $sUsername=htmlspecialchars(stripslashes($username));
    return $sUsername;
  }
  public function getRole($username){
    $db = new Database();
    $db->query("select role from users where username=:username");
    $db->bind(':username',$username);
    $db->execute();
    $row=$db->fetchColumn();
    return $row;
  }
}
$valid = new Validate();
