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
require_once('db/db.php');
//проверка email
register($data, $pdo);

header('Location:login-form.php');


