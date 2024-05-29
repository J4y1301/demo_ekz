<?php
session_start();
require_once("bd.php");
if (!empty($_POST['login']) &&  !empty($_POST['password'])) {
    $users_login = $_POST['login'];
    $users_password = md5($_POST['password']);
    $result = mysqli_query($link, "SELECT * FROM users WHERE users_login = '$users_login' AND users_password = '$users_password'");
    $user = mysqli_fetch_assoc($result);
    if(!empty($user)){
        $_SESSION['auth'] = true;
        $_SESSION['users_id'] = $user['users_id'];
        $_SESSION['users_status'] = $user['users_status'];
        if ($_SESSION['users_status'] == '0'){ 
            header("Location: admin.php"); 
        } 
        elseif ($_SESSION['users_status'] == '1'){ 
            header("Location:user_problems.php"); 
        } 
        

    }else{
        echo "Неверный логин или пароль.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Техносервис</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
        <h1>ООО Техносервис</h1>
    </header>
    <nav>
        <a href="ihdex.php">Главная</a>
        <a href="user_problems.php">Подать заявку</a>
    </nav>
    <main>
        <h2>Авторизация</h2>
        <form method="POST">
            <label for="login">Логин</label>
            <input type="text" name="login" id="login">
            <label for="password">Пароль</label>
            <input type="password" name="password" id="password">
            <button>Войти</button>
        </form>
        <?php
        if(isset($error_auth)){
            echo$error_auth;
        }
        ?>
    </main>
</body>
</html>