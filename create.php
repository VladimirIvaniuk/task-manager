<?php
session_start();

require_once ('database/db.php');
$imageName=uploadImage($_FILES['image']);

$data=[
    'title'=>$_POST['title'],
    'description'=>$_POST['description'],
    'image'=>$imageName,
    'user_id'=>$_SESSION['user']['id']
];
foreach ($data as $value){
    if(empty($value)){
        require 'errors.php';
        exit();
    }
}

addTask($data, $pdo);

header('Location:list.php');