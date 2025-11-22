<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductClientController extends AbstractController
{
    #[Route('/products', name: 'client_products')]
    public function products(ProductRepository $repo): Response
    {
        return $this->render('product_client/index.html.twig', [
            'products' => $repo->findAll()
        ]);
    }
}
