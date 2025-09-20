<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Category;
use App\Form\CategoryType;

final class CategoryController extends AbstractController
{
    #[Route('admin/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        
        
        return $this->render('admin/category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
    
    #[Route('admin/add/category', name: 'app_category_add')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
       $category = new Category();

       $form = $this->createForm(CategoryType::class, $category);

        if($form->isSubmitted() && $form->isValid()) {
           $entityManager->persist($category); 
           $entityManager->flush();

           return $this->redirectToRoute('app_category_add');
        }

       return $this->render('admin/category/new.html.twig');
    }
}
