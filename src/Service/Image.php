<?php

namespace App\Service;

class Image
{
    public int $id;
    public string $path;

    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id) : int
    {
        return $this->id = $id;
    }

    public function getPath() : string
    {
        return $this->path;
    }

    public function setPath(string $path) : string
    {
        return $this->path = $path;
    }

}