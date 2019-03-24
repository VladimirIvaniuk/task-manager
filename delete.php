<?php
session_start();
require_once('db/db.php');
$data=$_GET['id'];
deleteTask($pdo, $data);
header('Location:list.php');
?>