<?php

namespace App\Controller;

use App\Entity\Service;
use App\Entity\Reservation;
use App\Repository\ServiceRepository;
use App\Repository\CoachRepository;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(): Response
    {
        return $this->redirectToRoute('client_services');
    }

    #[Route('/services', name: 'client_services')]
    public function services(
        Request $request,
        ServiceRepository $serviceRepo,
        CoachRepository $coachRepo
    ): Response {
        $cat = $request->query->get('cat');
        $coachId = $request->query->get('coach');

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

    #[Route('/service/{id}', name: 'client_service_show')]
    public function showService(Service $service): Response
    {
        return $this->render('home/service_show.html.twig', [
            'service' => $service
        ]);
    }

    #[Route('/service/{id}/reserve', name: 'client_service_reserve')]
    public function reserveService(
        Service $service,
        EntityManagerInterface $em
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $reservation = new Reservation();
        $reservation->setUser($this->getUser());
        $reservation->setService($service);
        $reservation->setDateReservation(new \DateTime());
        $reservation->setStatus('en_attente');

        $em->persist($reservation);
        $em->flush();

        $this->addFlash('success', 'Réservation effectuée ✅');
        return $this->redirectToRoute('client_reservations');
    }

    #[Route('/reservations', name: 'client_reservations')]
    public function myReservations(ReservationRepository $repo): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $reservations = $repo->findBy(
            ['user' => $this->getUser()],
            ['dateReservation' => 'DESC']
        );

        return $this->render('reservation_client/index.html.twig', [
            'reservations' => $reservations
        ]);
    }
}
