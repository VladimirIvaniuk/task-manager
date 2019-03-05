<?php
$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['password'];
foreach ($_POST as $item) {
    if (empty($item)) {
        require 'errors.php';
        exit();
    }
}
$pdo=new PDO('mysql:host=localhost;dbname=task-manager','root','');
$sql="SELECT * FROM users WHERE email=:email";
$statement=$pdo->prepare($sql);
$statement->execute([':email'=>$email]);
$user=$statement->fetchColumn();
if($user){
    $errorMassage="Пользователь с таким email уже есть";
    include 'errors.php';
    exit();
}