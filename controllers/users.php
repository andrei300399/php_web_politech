<?php
include SITE_ROOT . "/database/db.php";

$errMsg = [];

function userAuth($user){
    $_SESSION['id'] = $user['id'];
    $_SESSION['login'] = $user['login'];
    header('location: ' . BASE_URL);
}

$users = selectAll('user');

// Код для формы авторизации
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buttonLogin'])){

    $login = trim($_POST['login']);
    $pass = trim($_POST['password']);

    if($login === '' || $pass === '') {
        array_push($errMsg, "Не все поля заполнены!");
    }else{
        $existence = selectOne('user', ['login' => $login]);
        if($existence && $pass == $existence['password']){
            userAuth($existence);
        }else{
            array_push($errMsg, "Почта либо пароль введены неверно!");
        //     header('refresh:0;url='. BASE_URL);
        //     echo '<script>
        //     alert("Неверный логин или пароль!");
        //   </script>';
        }
    }
}else{
    $email = '';
}
