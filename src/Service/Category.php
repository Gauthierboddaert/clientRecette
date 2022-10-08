<?php

namespace App\Service;

class Category
{
    public string $type;
    

    public function getType() : string
    {
        return $this->type;
    }

    public function setType(string $type) : string
    {
        return $this->type = $type;
    }

}