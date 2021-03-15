<?php


namespace App\Models;


class VariableObject
{
    private $rawName;
    private $functionName;
    private $isBoolean;

    public function __construct()
    {
        $this->rawName = '';
        $this->functionName = '';
        $this->isBoolean = false;
    }

    public function getRawName()
    {
        return $this->rawName;
    }

    public function setRawName($rawName)
    {
        $this->rawName = $rawName;
    }

    public function getFunctionName()
    {
        return $this->functionName;
    }

    public function setFunctionName($functionName)
    {
        $this->functionName = $functionName;
    }

    public function isBoolean(){
        return $this->isBoolean;
    }

    public function setIsBoolean($isBoolean){
        $this->isBoolean = $isBoolean;
    }
}
