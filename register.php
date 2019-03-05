<?php
$data=[
    'name'=>$_POST['name'],
    'email'=>$_POST['email'],
    'password'=>$_POST['password']
];
//проверка на пустоту
foreach ($_POST as $item) {
    if (empty($item)) {
        require 'errors.php';
        exit();
    }
}
//соединение с БД
$pdo=new PDO('mysql:host=localhost;dbname=task-manager','root','');

//проверка email
$sql="SELECT * FROM users WHERE email=:email";
$statement=$pdo->prepare($sql);
$statement->execute([':email'=>$data['email']]);
$user=$statement->fetchColumn();
if($user){
    $errorMassage="Пользователь с таким email уже есть";
    include 'errors.php';
    exit();
}

//если всё хорошо сохраняем пользователя в БД
$sql="INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
$statement=$pdo->prepare($sql);
//хэшируем пароль
$data['password']=md5($data['password']);
$result=$statement->execute($data);
if(!$result){
    $errorMassage="Ошибка регистрации";
    require "errors.php";
    exit();
}
header('Location:login-form.php');


