<?php

namespace App\Controller;

use App\Entity\Coach;
use App\Repository\CoachRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachClientController extends AbstractController
{
    // List coachs
    #[Route('/coachs', name: 'client_coachs')]
    public function index(CoachRepository $repo): Response
    {
        return $this->render('coach_client/index.html.twig', [
            'coachs' => $repo->findAll()
        ]);
    }

    // Coach detail
    #[Route('/coach/{id}', name: 'client_coach_show')]
    public function show(Coach $coach): Response
    {
        return $this->render('coach_client/show.html.twig', [
            'coach' => $coach
        ]);
    }
}
