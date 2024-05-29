<?php
session_start();
if (empty($_SESSION['auth'])){
    header("Location:index.php");
}
if($_SESSION['users_status'] != '0'){
    header("Location:user_problems_all.php");
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
        <a href="admin.php">Главная</a>
        <a href="problems.php">Подать заявку</a>
        <a href="add_worker.php">Добавить исполнителя</a>
        <a href="update_problems_status.php">Изменить статус заявки</a>
        <a href="update_problems_describe.php">Изменить описание проблемы</a>
        <a href="add_comment.php">Добавить комментарий</a>
        <a href="logout.php">Выход</a>
    </nav>
    <main>
        <h2>Изменение описание проблемы</h2>
        <form method="POST">
        <table>
            <tr>
                <td><label for = "problems_id">Номер заявки</label></td>
                <td><input type = "text" name = "problems_id" id = "problems_id"></td>
            </tr>
            <tr>
                <td><label for="problems_describe">Сменить описание</label></td>
                <td><textarea id="problems_describe" name="problems_describe"></textarea></td>
            </tr>
            <tr>
                <td></td>
                <td><button>Изменить</button></td>
            </tr>
        </table>
        </form>
        <?php
        require_once("bd.php");
        if(!empty($_POST['problems_id'])&&!empty($_POST['problems_describe'])){
         $problems_id = $_POST['problems_id'];
         $problems_describe = $_POST['problems_describe'];
         $result = mysqli_query($link, "UPDATE problems SET problems_describe = '$problems_describe' WHERE problems_id = '$problems_id'");
        if($result =='true'){
            header("Location: admin.php");
        } else {
            echo "Ошибка";
        }
}
?>
    </main> 
</body>
</html>