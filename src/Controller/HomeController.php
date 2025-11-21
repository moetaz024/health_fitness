<?php
namespace App\Controller;

use App\Repository\ServiceRepository;
use App\Repository\CoachRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/services', name: 'client_services')]
    public function services(
        Request $request,
        ServiceRepository $serviceRepo,
        CoachRepository $coachRepo
    ): Response
    {
        $cat = $request->query->get('cat');        // /services?cat=yoga
        $coachId = $request->query->get('coach'); // /services?coach=2

        if ($cat) {
            $services = $serviceRepo->findBy(['categorie' => $cat]);
        } elseif ($coachId) {
            $services = $serviceRepo->findBy(['coach' => $coachId]);
        } else {
            $services = $serviceRepo->findAll();
        }

        return $this->render('home/services.html.twig', [
            'services' => $services,
            'coachs' => $coachRepo->findAll(),
            'selectedCat' => $cat,
            'selectedCoach' => $coachId,
        ]);
    }
}