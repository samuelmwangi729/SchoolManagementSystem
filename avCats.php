<?php
session_start();
error_reporting(0);
require_once('Database.php');
$db=new Database();
$db->query('SELECT * FROM student ')
