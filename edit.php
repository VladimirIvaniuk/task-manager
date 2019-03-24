<?php
require_once('db/db.php');
$imageName=uploadImage($_FILES['image']);

$data=[
    'id'=>$_GET['id'],
    'title'=>$_POST['title'],
    'description'=>$_POST['description'],
    'image'=>$imageName,
    'user_id'=>6
];
update($pdo, $data);