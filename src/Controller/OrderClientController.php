<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderClientController extends AbstractController
{
    #[Route('/orders', name:'client_orders')]
    public function myOrders(OrderRepository $repo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $orders = $repo->findBy(
            ['user' => $this->getUser()],
            ['dateCreation' => 'DESC']
        );

        return $this->render('order_client/index.html.twig', [
            'orders' => $orders
        ]);
    }
}
