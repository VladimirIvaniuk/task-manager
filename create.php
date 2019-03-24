<?php
session_start();

function uploadImage($image){
    $name_img=$image['name'];
    $tmp_name=$image['tmp_name'];
    $imageType=pathinfo($name_img, PATHINFO_EXTENSION);
    $imageName=uniqid(). '.'.$imageType;
    move_uploaded_file($tmp_name, "uploads/".$imageName);
    return $imageName;
}
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
function addTask(){
    $pdo=new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');
    $sql='INSERT INTO tasks(title, description, image, user_id)VALUES (:title, :description, :image, :user_id)';
    $statement=$pdo->prepare($sql);
//    $statement->bindParam(':title',$_POST['title']);
//    $statement->bindParam(':description',$_POST['description']);
//    $statement->bindParam(':image',$imageName);
//    $statement->bindParam(':user_id',$_SESSION['user']['id']);
    $statement->execute($GLOBALS['data']);
}
addTask();

header('Location:list.php');