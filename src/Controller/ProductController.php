<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Form\ProductType;

final class ProductController extends AbstractController
{
    #[Route('/admin/view/products', name: 'app_product')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        
        return $this->render('admin/product/index.html.twig', [
            'products' => $products
        ]);
    }
    #[Route('/admin/add/product', name: 'app_product_add')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $product->setCreatedAt(new \DateTimeImmutable());
        }

        return $this->render('admin/product/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    
}
