<?php

namespace App\Controller;

use App\Controller\Form\LoginFormType;
use App\Controller\Form\RegistrationFormType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logoutAction()
    {
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }

    #[Route('/login', name: 'app_login')]
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(LoginFormType::class);
        $form->handleRequest($request);

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'loginForm' => $form->createView(),
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/registration', name: 'app_register')]
    public function registrationAction(Security $security, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $pass = $userPasswordHasher->hashPassword(
                $user,
                $form->get('plainPassword')->getData()
            );
            $user->setPassword($pass);

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $security->login($user);
            return $this->redirectToRoute('url_coder_index');
        }

        return $this->render('auth/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
