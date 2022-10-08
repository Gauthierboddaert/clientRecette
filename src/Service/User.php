<?php

namespace App\Service;

class User
{
    public int $id = 0;
    public string $email;
    public array $roles;
    public string $username;
    public string $token;


    // public function __construct(int $id, string $email, array $roles, string $username)
    // {
    //     $this->id = $id;
    //     $this->email = $email;
    //     $this->username = $username;
    //     $this->roles = $roles;
    // }

    public function getId() : int
    {
        return $this->id;
    }

    public function setId(int $id) : int
    {
        return $this->id = $id;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function setEmail(string $email) : string
    {
        return $this->email = $email;
    }

    public function getRoles() : array
    {
        return $this->roles;
    }

    public function setRoles(array $roles) : array
    {
        return $this->roles = $roles;
    }

    public function getUsername() : string
    {
        return $this->username;
    }

    public function setUsername(string $username) : string
    {
        return $this->username = $username;
    }

    public function getToken() : string
    {
        return $this->token;
    }

    public function setToken(string $token) : string
    {
        return $this->token = $token;
    }

}