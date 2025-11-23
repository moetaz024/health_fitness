<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;

class ForgotPasswordController extends AbstractController
{
    #[Route('/forgot-password', name: 'app_forgot_password')]
    public function request(
        Request $request,
        UserRepository $userRepo,
        EntityManagerInterface $em,
        MailerInterface $mailer
    ): Response {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');

            if ($email) {
                $user = $userRepo->findOneBy(['email' => $email]);

                if ($user) {
                    $code = random_int(100000, 999999);

                    $user->setResetCode((string) $code);
                    $expiresAt = new \DateTimeImmutable('+15 minutes');
                    $user->setResetCodeExpiresAt(\DateTime::createFromInterface($expiresAt));

                    $em->flush();

                    $mail = (new TemplatedEmail())
                        ->from(new Address(
                            $this->getParameter('mailer_from_email'),
                            $this->getParameter('mailer_from_name')
                        ))
                        ->to($user->getEmail())
                        ->subject('Code de réinitialisation du mot de passe')
                        ->htmlTemplate('security/reset_password_email.html.twig')
                        ->context([
                            'code' => $code,
                            'user' => $user,
                        ]);

                    $mailer->send($mail);

                    $request->getSession()->set('reset_email', $email);
                }

                $this->addFlash('success', 'Si un compte existe avec cet email, un code de réinitialisation a été envoyé.');
                return $this->redirectToRoute('app_reset_password');
            }
        }

        return $this->render('security/forgot_password.html.twig');
    }

    #[Route('/reset-password', name: 'app_reset_password')]
    public function reset(
        Request $request,
        UserRepository $userRepo,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $hasher
    ): Response {
        $session = $request->getSession();
        $email = $session->get('reset_email');

        if (!$email) {
            $this->addFlash('danger', 'Aucune demande de réinitialisation.');
            return $this->redirectToRoute('app_forgot_password');
        }

        if ($request->isMethod('POST')) {
            $code = $request->request->get('code');
            $pwd1 = $request->request->get('password');
            $pwd2 = $request->request->get('password_confirm');

            $user = $userRepo->findOneBy(['email' => $email]);

            if (!$user || !$user->getResetCode() || $user->getResetCode() !== $code) {
                $this->addFlash('danger', 'Code invalide.');
            } elseif ($user->getResetCodeExpiresAt() && $user->getResetCodeExpiresAt() < new \DateTime()) {
                $this->addFlash('danger', 'Code expiré. Veuillez recommencer.');
            } elseif ($pwd1 !== $pwd2 || strlen((string) $pwd1) < 8) {
                $this->addFlash('danger', 'Mot de passe invalide ou non confirmé (min 8 caractères).');
            } else {
                $user->setPassword($hasher->hashPassword($user, (string) $pwd1));
                $user->setResetCode(null);
                $user->setResetCodeExpiresAt(null);

                $em->flush();
                $session->remove('reset_email');

                $this->addFlash('success', 'Mot de passe mis à jour. Vous pouvez vous connecter.');
                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('security/reset_password.html.twig', [
            'email' => $email,
        ]);
    }
}
