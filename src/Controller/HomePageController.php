<?php

namespace App\Controller;

use App\Service\User;
use App\Form\Type\ConnectType;
use App\Form\Type\RecetteType;
use App\Service\CallApiService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomePageController extends AbstractController
{

    private CallApiService $api;
    private User $user;
    // private Session $session;

    public function __construct(CallApiService $api, User $user)
    {
        $this->api = $api;
        $this->user = $user;
    }

    #[Route('/home', name: 'homePage')]
    public function index(Request $request): Response
    {
        return $this->render('home_page/index.html.twig', [
            "recettes" => $this->api->getRecettes(),
            "user" => $this->user
        ]);
    }

    #[Route('/home/new', name: 'new_recette')]
    public function newRecette(Request $request): Response
    {
        $form = $this->createForm(RecetteType::class);
        $form->createView();
    
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tab = [$form->get('images') ->getData(), $form->getData() ];
            $this->api->postRecette($tab);
        }

        return $this->render('home_page/new.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/login', name: 'connect')]
    public function Connect(Request $request): Response
    {
        if($this->user->getId() != 0){
            return $this->redirectToRoute('homePage'); 
        }

        $form = $this->createForm(ConnectType::class);
        $form->createView();
    
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $this->user = $this->api->connect($form->getData());
           
            if($this->user->getId() == 0){
                return $this->redirectToRoute('connect');
            }else{
                // $this->session = new Session(); 
                // $this->session = $request->getSession();
                // $this->session->set('user', $this->user);
                return $this->redirectToRoute('homePage'); 
            }
        }

        return $this->render('home_page/new.html.twig', [
            "form" => $form->createView()
        ]);
        
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): Response
    {
    
    //    $this->get('session')->clear();
       return $this->redirectToRoute('homePage'); 
    }
}
