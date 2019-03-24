<?php
$pdo=new PDO('mysql:host=localhost;dbname=task-manager', 'root', '');
function login($data, $pdo){
    $sql = "SELECT * FROM users WHERE email=:email AND password=:password";
    $statement=$pdo->prepare($sql);
    $statement->execute($data);
    $user=$statement->fetch(PDO::FETCH_ASSOC);
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
}
function register($data, $pdo){
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
}

function uploadImage($image){
    $name_img=$image['name'];
    $tmp_name=$image['tmp_name'];
    $imageType=pathinfo($name_img, PATHINFO_EXTENSION);
    $imageName=uniqid(). '.'.$imageType;
    move_uploaded_file($tmp_name, "uploads/".$imageName);
    return $imageName;
}
function addTask($data, $pdo){
    $sql='INSERT INTO tasks(title, description, image, user_id)VALUES (:title, :description, :image, :user_id)';
    $statement=$pdo->prepare($sql);
    $statement->execute($data);
}
function allTasks($pdo){
    $sql="SELECT * FROM tasks";
    $statement=$pdo->prepare($sql);
    $statement->execute();
    $tasks=$statement->fetchAll(PDO::FETCH_ASSOC);
    return $tasks;
}
function oneTask($pdo, $data){

    $sql = "SELECT * FROM tasks WHERE id=:id";
    $statement=$pdo->prepare($sql);
    $statement->bindParam(':id', $data);
    $statement->execute();
    $task=$statement->fetch(PDO::FETCH_ASSOC);
    return $task;
}
function update($pdo, $data)
{
    $str_data = '';
    foreach ($data as $key => $value) {
        $str_data .= $key . "=:$key, ";
    }
    $str_data = rtrim($str_data, ", ");
    $sql = "UPDATE tasks SET $str_data WHERE id = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute($data);

}