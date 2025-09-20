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
use App\Service\UploaderHelper;

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
    public function new(Request $request, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper): Response
    {
        $product = new Product();
        
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $product->setCreatedAt(new \DateTimeImmutable());

            $uploadedFile = $form['image']->getData();

            if($uploadedFile) {
               $newFilename = $uploaderHelper->uploadProductImage($uploadedFile);
               $product->setImage($newFilename);
            }

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product');
        }

        return $this->render('admin/product/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    
}
