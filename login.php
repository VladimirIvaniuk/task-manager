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
require_once ('database/db.php');

login($data, $pdo);
header('Location:login-form.php');
