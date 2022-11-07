<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    // /**
    //  * @Route("/toto", name="app_main" )
    //  */
    
    #[Route('/main', name:'app_main')]
    public function index(): Response
    {
        // $this représente ici l'objet en cours.
        return $this->render('main/index.html.twig', [
            'controller_name' => 'Hello World'
        ]);
    }

    #[Route('/', name:'app_accueil')]
    public function accueil(){
        return $this->render('main/accueil.html.twig');
    }
    
}

