<?php
session_start();

foreach ($_POST as $value){
    if(empty($value)){
        require 'errors.php';
        exit();
    }
}
$data=[
    'email'=>$_POST['email'],
    'password'=>md5($_POST['password'])
];

$pdo=new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');
$sql = "SELECT * FROM users WHERE email=:email AND password=:password";
$statement=$pdo->prepare($sql);
$statement->execute($data);
$user=$statement->fetch();
if($user){
    $_SESSION['user']=$user;
    header('Location:list.php');
    exit();
}
else {
    $errorMassage = "Ошибка! Неверно логин или пароль";
    require "login-form.php";
    exit();
}
header('Location:login-form.php');
