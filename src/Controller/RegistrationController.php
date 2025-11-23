<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $hasher,
        EntityManagerInterface $em,
        MailerInterface $mailer
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $plainPassword = $form->get('plainPassword')->getData();
            $user->setPassword($hasher->hashPassword($user, $plainPassword));

            // ✅ generate verification code
            $code = random_int(100000, 999999);
            $user->setVerificationCode((string)$code);
            $user->setVerificationCodeExpiresAt(new \DateTime('+15 minutes'));
            $user->setIsVerified(false);

            $em->persist($user);
            $em->flush();

            // ✅ send code using parameters
            $mail = (new TemplatedEmail())
                ->from(new Address(
                    $this->getParameter('mailer_from_email'),
                    $this->getParameter('mailer_from_name')
                ))
                ->to($user->getEmail())
                ->subject('Code de vérification - Health Fitness')
                ->htmlTemplate('registration/verification_code_email.html.twig')
                ->context([
                    'code' => $code,
                    'user' => $user,
                ]);

            $mailer->send($mail);

            $request->getSession()->set('verify_email', $user->getEmail());

            $this->addFlash('success', 'Un code de vérification a été envoyé à votre Gmail.');
            return $this->redirectToRoute('app_verify_code');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/verify-code', name: 'app_verify_code')]
    public function verifyCode(Request $request, EntityManagerInterface $em): Response
    {
        $email = $request->getSession()->get('verify_email');
        if (!$email) {
            $this->addFlash('danger', 'Aucune inscription trouvée.');
            return $this->redirectToRoute('app_register');
        }

        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        if (!$user) {
            $this->addFlash('danger', 'Utilisateur introuvable.');
            return $this->redirectToRoute('app_register');
        }

        if ($request->isMethod('POST')) {
            $code = $request->request->get('code');

            if ($user->getVerificationCode() !== $code) {
                $this->addFlash('danger', 'Code incorrect.');
            } elseif ($user->getVerificationCodeExpiresAt() < new \DateTime()) {
                $this->addFlash('danger', 'Code expiré.');
            } else {
                $user->setIsVerified(true);
                $user->setVerificationCode(null);
                $user->setVerificationCodeExpiresAt(null);
                $em->flush();

                $request->getSession()->remove('verify_email');

                $this->addFlash('success', 'Compte vérifié ✅ يمكنك login توّا.');
                return $this->redirectToRoute('app_login');
            }
        }

        return $this->render('registration/verify_code.html.twig', [
            'email' => $email
        ]);
    }

    #[Route('/verify-code/resend', name: 'app_verify_code_resend')]
    public function resendCode(
        Request $request,
        EntityManagerInterface $em,
        MailerInterface $mailer
    ): Response {
        $email = $request->getSession()->get('verify_email');
        if (!$email) return $this->redirectToRoute('app_register');

        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        if(!$user) return $this->redirectToRoute('app_register');

        $code = random_int(100000, 999999);
        $user->setVerificationCode((string)$code);
        $user->setVerificationCodeExpiresAt(new \DateTime('+15 minutes'));
        $em->flush();

        $mail = (new TemplatedEmail())
            ->from(new Address(
                $this->getParameter('mailer_from_email'),
                $this->getParameter('mailer_from_name')
            ))
            ->to($user->getEmail())
            ->subject('Nouveau code de vérification')
            ->htmlTemplate('registration/verification_code_email.html.twig')
            ->context([
                'code' => $code,
                'user' => $user,
            ]);

        $mailer->send($mail);

        $this->addFlash('success', 'Nouveau code envoyé.');
        return $this->redirectToRoute('app_verify_code');
    }
}
