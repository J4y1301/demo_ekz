<?php
session_start();
if (empty($_SESSION['auth'])){
    header("Location:index.php");
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
        <h2>Подать заявку</h2>
        <form class="problems" method="POST">
            <table>
                <tr>
                    <td><label for ="problems_equipment">Оборудование</label></td>
                    <td><input type="text" id="problems_equipment" name="problems_equipment"></td>
                </tr>
                <tr>
                    <td>Тип неисправности</td>
                    <td>
                        <select name="problems_problem">
                            <option value="не включается">не включается</option>
                            <option value="странности в работе">странности в работе</option>
                            <option value="нехарактерные звуки">нехарактерные звуки</option>
                            <option value="другое">другое</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="problems_describe">Описание проблемы</label></td>
                    <td><textarea id="problems_describe" name="problems_describe"></textarea></td>
                </tr>
                <tr>
                    <td><label for="problems_user_full_name">ФИО клиента</label></td>
                    <td><input type="text" id="problems_user_full_name" name="problems_user_full_name" placeholder="Иванов И.И."></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button>Отправить</button></td>
                </tr>
            </table>
        </form>
    </main>
    <?php
    require_once("bd.php");
    if(!empty($_POST['problems_equipment'])&&!empty($_POST['problems_problem'])&&!empty($_POST['problems_describe'])&&!empty($_POST['problems_user_full_name'])){
        $problems_equipment = $_POST['problems_equipment'];
        $problems_problem = $_POST['problems_problem'];
        $problems_describe = $_POST['problems_describe'];
        $problems_user_full_name = $_POST['problems_user_full_name'];
        $problems_users_id = $_SESSION['users_id'];
        $result = mysqli_query($link, "INSERT INTO problems(problems_equipment, problems_problem, problems_describe, problems_user_full_name, problems_users_id) 
        VALUES ('$problems_equipment','$problems_problem','$problems_describe','$problems_user_full_name','$problems_users_id')");
        if($result =='true'){
            header("Location: admin.php");
        } else {
            echo "Информация не добавлена";
        }
    }
    ?>
</body>
</html>