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
        <h2>Изменение статуса заявки</h2>
        <form method="POST">
        <table>
            <tr>
                <td><label for = "problems_id">Номер заявки</label></td>
                <td><input type = "text" name = "problems_id" id = "problems_id"></td>
            </tr>
            <tr>
                <td>Сменить статус заявки</td>
                <td><select name="problems_status">
                        <option value="в ожидание">в ожидание</option>
                        <option value="в работе">в работе</option>
                        <option value="выполнено">выполнено</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><button>Изменить</button></td>
            </tr>
        </table>
        </form>
        <?php
        require_once("bd.php");
        if(!empty($_POST['problems_id'])&&!empty($_POST['problems_status'])){
         $problems_id = $_POST['problems_id'];
         $problems_status = $_POST['problems_status'];
         $_SESSION['post_status'] = $_POST['problems_status'];
         $result_1 = mysqli_query($link, "UPDATE problems SET problems_status = '$problems_status' WHERE problems_id = '$problems_id'");
         if($problems_status == 'выполнено'){
            $result_11 = mysqli_query($link, "UPDATE problems SET problems_date_end = NOW(), problems_date_diff = TIMEDIFF(problems_date_end , problems_date_start) WHERE problems_id = '$problems_id'");
        } else {
            $result_12 = mysqli_query($link, "UPDATE problems SET problems_date_end = NULL, problems_date_diff = '00:00:00' WHERE problems_id = '$problems_id'");
        }
        if($result_1 =='true'){
            $_SESSION['change_status'] = "Статус заказа ". $problems_id ." изменен на: ". $_SESSION['post_status'];
            header("Location: admin.php");
        } else {
            echo "Ошибка";
        }
}
?>
    </main> 
</body>
</html>