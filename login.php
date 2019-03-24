<?php
session_start();
require_once('db/db.php');
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


login($data, $pdo);
header('Location:login-form.php');
