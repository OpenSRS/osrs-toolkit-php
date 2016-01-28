<?php

namespace opensrs;

class APIException extends \Exception
{
    protected $info;

    public function __construct($msg, $info)
    {
       $this->info = $info;  
       parent::__construct($msg);
    }

    public function getInfo()
    {
        return $this->info; 
    }
}
