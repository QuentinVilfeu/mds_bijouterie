<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin/category', name: 'app_admin_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        // dd($categories);
        return $this->render('admin/afficher_category.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/admin/category/add', name: 'app_admin_category_add')]
    public function addCategory(Request $request, EntityManagerInterface $manager, CategoryRepository $categoryRepository): Response
    {
        // Pour ajouter une categorie on a besoin de créer un nouvel objet de la classe/Entity Category
        // créer un nouvel objet => instanciation
        $category = new Category();

        // dump($category); // Pour le moment mon objet est vide

        // Création du formulaire 
        $form = $this->createForm(CategoryType::class, $category);
        // dump($form);

        // Traitement des données
        // handleRequest() permet de gérer le traitement de la saisie des données.
        // Lorsque l'on soumet le formulaire $_POST est transmis à la même url grâce à la request.
        // handleRequest() va remplir automatiquement mon objet $category
        $form->handleRequest($request);
        // dump($category); // A ce niveau le name est rempli. L'id est toujours vide car l'objet n'est pas envoyé en BDD 

        // On doit vérifier si le formulaire est envoyé et si les conditions indiqués dans l'entité (Assert) sont validée.
        if ($form->isSubmitted() && $form->isValid()) {
            
            // dump($category);
            // // on peut maintenant réellement envoyé en BDD
            // $manager->persist($category); // Definir l'objet à envoyer
            // $manager->flush(); // Envoyer l'objet en question

            // Symfony a développé une méthode save qui me permet de faire le persist() et le flush() pour moi.
            // Cette méthode provient de la classe CategoryRepository. 
            // On retrouvera dans les repository TOUTES les requêtes vers notre BDD
            $categoryRepository->save($category, true);


            // dd($category); // Ici notre objet est complet. L'id est maintenant renseigné.

            // Maintenant je peux afficher un message de succès et faire la redirection vers la page 'afficher/category'

            /*
                addFlash() est une méthode qui permet de véhiculer les données entre les pages. 
                Elle attend 2 paramètres : 
                        - le nom/id du flash du message
                        - le message, la valeur.
             */

            $this->addFlash('success', 'La category a bien été ajoutée');
            // $this->addFlash('success2', 'message2');
            // $this->addFlash('success3', 'message3');
            
            return $this->redirectToRoute('app_admin_category');

        }

        return $this->renderForm('admin/ajouter_category.html.twig', [
            'formCategory' => $form
        ]);
    }

    #[Route('/admin/category/update/{id}', name: 'app_admin_category_update')]
    public function updateCategory($id, CategoryRepository $categoryRepository)
    {
        $category = $categoryRepository->find($id);
        


        return $this->render('admin/update_category.html.twig');
    }

    #[Route('/admin/category/update2/{id}', name: 'app_admin_category_update2')]
    public function updateCategory2(Category $category, Request $request, EntityManagerInterface $manager)
    {   
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        // dump($category);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($category);
            $manager->flush();

            $this->addFlash('success', "La catégorie N°".$category->getId()." a bien été modifée");

            return $this->redirectToRoute('app_admin_category');
        }

        return $this->renderForm('admin/update_category.html.twig', [
            'formCategory' => $form
        ]);
    }
}
