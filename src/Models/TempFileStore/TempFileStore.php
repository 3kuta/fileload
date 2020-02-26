<?php

namespace Models\TempFileStore;

use Models\Dtofile\DtoFile;

class TempFileStore
{
    public function save(DtoFile $dto)
    {
        session_start();
        $dto->id = $this->generateKey();
        $_SESSION['tmpFile'][$dto->id] = [
            'report' => $dto->report,
            'tmp' => $dto->tmp,
            'name' => $dto->name
        ];
    }
 
    public function get($key)
    {
        session_start();
        $data = $_SESSION['tmpFile'][$key] ?? null;
 
        if (empty($data)) {
            return null;
        }
 
        $dto = new DtoFile($data['report'], $data['tmp'], $data['name']);
        $dto->id = $key;
 
        return $dto;
    }
 
    public function clear()
    {
        session_start();
        unset($_SESSION['tmpFile']);
    }
 
    private function generateKey()
    {
        return md5(time());
    }
}
