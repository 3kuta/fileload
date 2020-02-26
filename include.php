<?php
 
function myAutoLoader(string $className)
{
    require_once __DIR__ . '/src/' . $className . '.php';
}

spl_autoload_register('myAutoLoader');

$store = new Models\TempFileStore\TempFileStore();

if(!$dto = $store->get($_GET['id'] ?? '')) {
    header('Location: index.php');
    die();
}
 
if ($_POST['overwrite'] === '1') {
    copy($dto->tmp, $dto->report);
    $con = new \Models\DbCon\DbCon();
    $con->insertTable($dto->name);
    $store->clear();
    
} elseif ($_POST['overwrite'] === '0') {
    header('Location: index.php');
}
?>

<form method="post">
    <div id="LoadReport">
        <p>Do you want to overwrite the file?</p>
        <button type="submit" name="overwrite" value="0">Нет</button>
        <button type="submit" name="overwrite" value="1">Да</button>
    </div>
</form>
