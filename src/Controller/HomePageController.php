<?php

namespace App\Controller;

use App\Service\User;
use App\Form\Type\ConnectType;
use App\Form\Type\RecetteType;
use App\Service\CallApiService;
use App\Service\Category;
use App\Service\Image;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomePageController extends AbstractController
{

    private CallApiService $api;
    private User $user;
    private RequestStack $requestStack;
    

    public function __construct(CallApiService $api, User $user, RequestStack $requestStack)
    {
        $this->api = $api;
        $this->user = $user;
        $this->requestStack = $requestStack;
    }

    #[Route('/home', name: 'homePage')]
    public function index(Request $request, SessionInterface $session): Response
    {
        return $this->render('home_page/index.html.twig', [
            "recettes" => $this->api->getRecettes(),
            "user" => $session->get('user')
        ]);
    }

    #[Route('/home/new', name: 'new_recette')]
    public function newRecette(Request $request, SessionInterface $session): Response
    {
        $form = $this->createForm(RecetteType::class);
        $form->createView();
    
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $userid = $session->get('user');
            $data = $form->getData(); 
            $category = new Category();
            $image = new Image();
            
            $category->setType($data['Category']->value);
            $image->setId(1);
            $image->setPath('cc');
            
            // $img = array('id' => 1,'path' => 'c');
            $jsonRequest = [
                'title' => $data['Nom'],
                'description' => $data['Descriptions'],
                'Category' => $category,
                'images' => [$image],
                'email' => $userid->getEmail()
            ];
           
            $this->api->postRecette($jsonRequest);

            return $this->redirectToRoute('homePage');
        }

        return $this->render('home_page/new.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/login', name: 'connect')]
    public function Connect(Request $request, SessionInterface $session): Response
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
                $session->set('user', $this->user);
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
    public function logout(SessionInterface $session): Response
    {
        $session->clear();
        return $this->redirectToRoute('homePage'); 
    }
}
