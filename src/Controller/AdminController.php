<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin/category', name: 'app_admin_category')]
    public function index(): Response
    {
        return $this->render('admin/afficher_category.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/admin/category/add', name: 'app_admin_category_add')]
    public function addCategory(): Response
    {
        // Pour ajouter une categorie on a besoin de créer un nouvel objet de la classe/Entity Category
        // créer un nouvel objet => instanciation
        $category = new Category();

        // dump($category); // Pour le moment mon objet est vide

        // Création du formulaire 
        $form = $this->createForm(CategoryType::class, $category);
        // dump($form);

        // Traitement des données
        

        return $this->renderForm('admin/ajouter_category.html.twig', [
            'formCategory' => $form
        ]);
    }
}
