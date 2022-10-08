<?php

namespace App\Service;

class UserManager
{
    public function getUser(array $data, string $token)
    {
        $user = new User();
        foreach($data as $request){
            $user->setId($request['id']);
            $user->setEmail($request['email']);
            $user->setUsername($request['username']);
            $user->setRoles($request['roles']);
        }
        $user->setToken($token);

        return $user;
    }

}