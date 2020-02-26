<?php

namespace Models\DtoFile;

class DtoFile
{
    public $id;
    public $report;
    public $tmp;
    public $name;
 
    public function __construct($report, $tmp, $name)
    {
        $this->report = $report;
        $this->tmp = $tmp;
        $this->name = $name;
    }
}
