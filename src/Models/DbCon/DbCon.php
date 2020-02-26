<?php

namespace Models\DbCon;

use Mysqli;

class DbCon
{
    public $mysqli;
    
    public function __construct()
    {
        $this->mysqli = new mysqli('localhost', 'root', '', 'test');
        
        if (mysqli_connect_errno()) {
            printf("Невозможно подключиться к базе данных. Код ошибки: %s\n", mysqli_connect_error());
            exit;
        }
    }
    
    public function insertTable($name)
    {
        $result = $this->mysqli->query("INSERT INTO first (name) VALUES ('$name')");
        return $result;
    }
    
    public function selectTable($tblrow, $tblname)
    {
        $result = $this->mysqli->query("SELECT ".$tblrow." FROM ".$tblname);
        
        return $result;
    }
}
