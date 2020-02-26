<?php

function myAutoLoader(string $className)
{
    require_once __DIR__ . '/src/' . $className . '.php';
}

spl_autoload_register('myAutoLoader');

$store = new Models\TempFileStore\TempFileStore();
$con = new Models\DbCon\DbCon();

if (isset($_POST['date']) && isset($_POST['name'])) {
    
    
    $date = $_POST['date'];
    $name = $_POST['name'];
 
    if ($_FILES['report']['name'] != '') {
 
        $filename = $_FILES['report']['name'];
        $dir = 'load/';
        $tmp = $dir . 'tmp/';
        $ext = substr($filename, strpos($filename,'.'), strlen($filename)-1);
        $dto = new Models\DtoFile\DtoFile(
            $dir . $date . $ext,
            $tmp . $date . $ext,
            $name
        );
 
        if (file_exists($dto->report)) {
            copy($_FILES['report']['tmp_name'], $dto->tmp);
            $store->save($dto);
            header('Location: include.php?id=' . $dto->id);
            exit;
        } else {
            copy($_FILES['report']['tmp_name'], $dto->report);
            echo "File loaded<br>";
            $con->insertTable($name);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Форма ввода</title>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td><label for="date">Дата</label></td>
                <td><input type="date" id="date" name="date"></td>
            </tr>
            <tr>
                <td><label for="name">Текст для БД</label></td>
                <td><input type="text" id="name" name="name"></td>
            </tr>
            <tr>
                <td><label for="customFile">Выбрать отчет</label></td>
                <td><input type="file" id="customFile" name="report"></td>
            </tr>
            <tr>
                <td colspan="2"><button type="submit">Load file to server</button></td>
            </tr>
        </table>
    </form>
    <hr>
    <h3>Таблица из БД</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>NAME</th>
        </tr>
        <?php
    
    $result = $con->selectTable('*', 'first');
    while ($row = mysqli_fetch_array($result)) {
    ?>

        <tr>
            <td><?= $row['ID']?></td>
            <td><?= $row['name']?></td>
        </tr>

        <?php
    }
    
    ?>
    </table>
</body>

</html>
