<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallApiService
{
    private $client;
    private UserManager $userManager;
    private User $user;

    public function __construct(HttpClientInterface $client, UserManager $userManager, User $user)
    {
        $this->client = $client;
        $this->userManager = $userManager;
        $this->user = $user;
    }

    public function getRecettes(): array
    {
        $response = $this->client->request(
            'GET',
            'http://127.0.0.1:8001/api/recette'
        );
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content;
    }

    public function postRecette(array $req) : array
    {
        dd($req);
        $response = $this->client->request(
            'POST',
            'http://127.0.0.1:8001/api/recette/new'
        );
        return [];
    }

    public function connect(array $req) 
    {
        $response = $this->client->request(
            'GET',
            'http://127.0.0.1:8001/api/loginUser',
            [
                "json" => ['username' => $req['Email'], "password" => $req['Password']]
            ]
        );

        $token = $this->client->request(
            'POST',
            'http://127.0.0.1:8001/api/login_check',
            [
                "json" => ['username' => $req['Email'], "password" => $req['Password']]
            ]
        );

        if($token->getStatusCode() == 401){
            return $this->user;
        }

        $this->user = $this->userManager->getUser($response->toArray(),  $token->getContent());
        
        return $this->user;
    }
}