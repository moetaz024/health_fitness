<?php

namespace App\Controller;

use App\Entity\Coach;
use App\Form\CoachType;
use App\Repository\CoachRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
<<<<<<< HEAD
=======
use Symfony\Component\String\Slugger\SluggerInterface;
>>>>>>> 82a889c (fixed admin dashboard)

#[Route('/admin/coach')]
#[IsGranted('ROLE_ADMIN')]
final class CoachController extends AbstractController
{
    #[Route(name: 'app_coach_index', methods: ['GET'])]
    public function index(CoachRepository $coachRepository): Response
    {
        return $this->render('coach/index.html.twig', [
            'coaches' => $coachRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_coach_new', methods: ['GET', 'POST'])]
<<<<<<< HEAD
    public function new(Request $request, EntityManagerInterface $entityManager): Response
=======
    public function new(Request $request, 
                        EntityManagerInterface $entityManager,
                        SluggerInterface $slugger): Response
>>>>>>> 82a889c (fixed admin dashboard)
    {
        $coach = new Coach();
        $form = $this->createForm(CoachType::class, $coach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
<<<<<<< HEAD
            $entityManager->persist($coach);
            $entityManager->flush();

            return $this->redirectToRoute('app_coach_index', [], Response::HTTP_SEE_OTHER);
=======

            /** @var UploadedFile $photoFile */
            $photoFile = $form->get('photoFile')->getData();

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

                $photoFile->move(
                    $this->getParameter('coaches_directory'),
                    $newFilename
                );

                // Save filename in database
                $coach->setPhoto($newFilename);
            }

            $entityManager->persist($coach);
            $entityManager->flush();

            return $this->redirectToRoute('app_coach_index');
>>>>>>> 82a889c (fixed admin dashboard)
        }

        return $this->render('coach/new.html.twig', [
            'coach' => $coach,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_coach_show', methods: ['GET'])]
    public function show(Coach $coach): Response
    {
        return $this->render('coach/show.html.twig', [
            'coach' => $coach,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_coach_edit', methods: ['GET', 'POST'])]
<<<<<<< HEAD
    public function edit(Request $request, Coach $coach, EntityManagerInterface $entityManager): Response
=======
    public function edit(Request $request, 
                         Coach $coach, 
                         EntityManagerInterface $entityManager,
                         SluggerInterface $slugger): Response
>>>>>>> 82a889c (fixed admin dashboard)
    {
        $form = $this->createForm(CoachType::class, $coach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
<<<<<<< HEAD
            $entityManager->flush();

            return $this->redirectToRoute('app_coach_index', [], Response::HTTP_SEE_OTHER);
=======

            $photoFile = $form->get('photoFile')->getData();

            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photoFile->guessExtension();

                $photoFile->move(
                    $this->getParameter('coaches_directory'),
                    $newFilename
                );

                $coach->setPhoto($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_coach_index');
>>>>>>> 82a889c (fixed admin dashboard)
        }

        return $this->render('coach/edit.html.twig', [
            'coach' => $coach,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_coach_delete', methods: ['POST'])]
    public function delete(Request $request, Coach $coach, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$coach->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($coach);
            $entityManager->flush();
        }

<<<<<<< HEAD
        return $this->redirectToRoute('app_coach_index', [], Response::HTTP_SEE_OTHER);
=======
        return $this->redirectToRoute('app_coach_index');
>>>>>>> 82a889c (fixed admin dashboard)
    }
}
