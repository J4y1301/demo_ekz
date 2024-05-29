<?php
session_start();
if (empty($_SESSION['auth'])){
    header("Location:index.php");
}
if($_SESSION['users_status'] != '0'){
    header("Location:user_problems_all.php");
}
require_once("bd.php");
$counter = mysqli_query($link, "SELECT COUNT(*) AS count FROM problems WHERE problems_status = 'выполнено'");
$result_1 = mysqli_fetch_assoc($counter);
$count = $result_1['count'];

if($count >= 0){
$avg_tame = mysqli_query($link, "SELECT ROUND(AVG(TIME_TO_SEC(problems_date_diff))) AS time_in_seconds FROM problems WHERE problems_status = 'выполнено'");
$result_2 = mysqli_fetch_assoc($avg_tame);
$get_time = $result_2['time_in_seconds'];
$time_format = timeFormat($get_time);
}

function timeFormat($seconds){
    $hours = $seconds / 3600;
    $minutes = ($seconds % 3060) / 60;
    $seconds = $seconds % 60;
    return sprintf("%02d часов %02d минут %02d секунд", $hours, $minutes, $seconds); 
}
$statisic = mysqli_query($link, "SELECT COUNT(CASE WHEN problems_problem = 'не включается' THEN 1 END) AS count_problem_1, 
COUNT(CASE WHEN problems_problem = 'странности в работе' THEN 1 END) AS count_problem_2, 
COUNT(CASE WHEN problems_problem = 'нехарактерные звуки' THEN 1 END) AS count_problem_3, 
COUNT(CASE WHEN problems_problem = 'другое' THEN 1 END) AS count_problem_4 FROM problems");
$result_3 = mysqli_fetch_assoc($statisic);
$statisic_1 = $result_3['count_problem_1'];
$statisic_2 = $result_3['count_problem_2'];
$statisic_3 = $result_3['count_problem_3'];
$statisic_4 = $result_3['count_problem_4'];
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
        <h2 class="admin_title">Панель администратора</h2>
<?php
if(!empty($_SESSION['change_status'])){
    echo "<p class='notice'>" .$_SESSION['change_status']."</p>";
    $_SESSION['change_status'] = null;
} 
?>
        <span><b>Количество выполненых заявок: </b><?php echo $count; ?></span>
        <span><b>Среднее время выполнения заявок: </b><?php echo $time_format; ?></span>
        <table class="problems_statistic">
            <tr>
                <td colspan="2"><b>Статистика по неиспараностям</b></td>
            </tr>
            <tr>
                <td>не включается:</td>
                <td><?php echo $statisic_1; ?></td>
            </tr>
            <tr>
                <td>странности в работе:</td>
                <td><?php echo $statisic_2; ?></td>
            </tr>
            <tr>
                <td>нехарактерные звуки:</td>
                <td><?php echo $statisic_3; ?></td>
            </tr>
            <tr>
                <td>другое:</td>
                <td><?php echo $statisic_4; ?></td>
            </tr>
        </table>

        <h2>Поиск заявки</h2>
        <form method="POST">
            <label for = "full_name_or_id"><b>Ведите ФИО или Номер заявки:</b></label>
            <input type = "text" name = "full_name_or_id" id = "full_name_or_id">
            <button>Найти</button>
        </form>
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
                <th>Комментарий</th>
                <th>Исполнитель</th>
            </tr>
    <?php
    if(!empty($_POST['full_name_or_id'])){
        $search = mysqli_query($link,"SELECT * FROM problems LEFT JOIN workers ON problems.
        problems_workers_id=workers.workers_id WHERE problems_user_full_name = '$_POST[full_name_or_id]' OR
        problems_id = '$_POST[full_name_or_id]'");
        while($row_1 = mysqli_fetch_assoc($search)){
            echo "<tr>
            <td>$row_1[problems_id]</td>
            <td>$row_1[problems_date_start]</td>
            <td>$row_1[problems_equipment]</td>
            <td>$row_1[problems_problem]</td>
            <td>$row_1[problems_describe]</td>
            <td>$row_1[problems_user_full_name]</td>
            <td>$row_1[problems_status]</td>
            <td>$row_1[problems_comment]</td>
            <td>$row_1[workers_full_name]</td>
            </tr>";
        }
    }
    else {
        $result_4 = mysqli_query($link, "SELECT * FROM problems LEFT JOIN workers ON problems.
        problems_workers_id=workers.workers_id ORDER BY problems_id DESC ");
        while($row_2 = mysqli_fetch_assoc($result_4)){
            echo "<tr>
            <td>$row_2[problems_id]</td>
            <td>$row_2[problems_date_start]</td>
            <td>$row_2[problems_equipment]</td>
            <td>$row_2[problems_problem]</td>
            <td>$row_2[problems_describe]</td>
            <td>$row_2[problems_user_full_name]</td>
            <td>$row_2[problems_status]</td>
            <td>$row_2[problems_comment]</td>
            <td>$row_2[workers_full_name]</td>
            </tr>";
        }
    }
    ?>  
        </table>
     </main>
</body>
</html>