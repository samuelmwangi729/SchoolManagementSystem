<?php
$admin=isAdmin($username);
if(isAdmin()){
  $password=password_verify($password,passwordHash($password))
  login($username,$password);
  header("Location: /staff/index.php");
}else{
  $error[]=$login_failure_Msg;
  header("Location: index.php");
}
