<?php

namespace App\Controller;

use App\Repository\ReservationRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\ServiceRepository;
use App\Repository\CoachRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(
        ReservationRepository $reservationRepo,
        OrderRepository $orderRepo,
        ProductRepository $productRepo,
        ServiceRepository $serviceRepo,
        CoachRepository $coachRepo
    ): Response
    {
        $resCount   = $reservationRepo->count([]);
        $orderCount = $orderRepo->count([]);
        $prodCount  = $productRepo->count([]);
        $servCount  = $serviceRepo->count([]);
        $coachCount = $coachRepo->count([]);

        $outStock = $productRepo->count(['stock' => 0]); // produits hors stock

        return $this->render('admin/index.html.twig', [
            'resCount'   => $resCount,
            'orderCount' => $orderCount,
            'prodCount'  => $prodCount,
            'servCount'  => $servCount,
            'coachCount' => $coachCount,
            'outStock'   => $outStock,
        ]);
    }
}
