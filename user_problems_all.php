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
        <a href="index.php">Главная</a>
        <a href="user_problems.php">Подать заявку</a>
        <a href="user_problems_all.php">Все заявки</a>
        <a href="logout.php">Выход</a>
    </nav>
    <main>
        <h2>Все заявки</h2>
        <table class = "all_problems">
            <tr>
                <th>Номер заявки</th>
                <th>Дата добавления</th>
                <th>Оборудование</th>
                <th>Тип неисправности</th>
                <th>Описание проблем</th>
                <th>ФИО клиента</th>
                <th>Статус заявки</th>
            </tr>
    <?php
    require_once("bd.php");
    $result = mysqli_query($link, "SELECT * FROM problems WHERE problems_users_id = '$_SESSION[users_id]'");
    while($row = mysqli_fetch_assoc($result)){
        echo "<tr>
        <td>$row[problems_id]</td>
        <td>$row[problems_date_start]</td>
        <td>$row[problems_equipment]</td>
        <td>$row[problems_problem]</td>
        <td>$row[problems_describe]</td>
        <td>$row[problems_user_full_name]</td>
        <td>$row[problems_status]</td>
        </tr>";
    }
?>  
        </table>
     </main>
</body>
</html>