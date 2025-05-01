<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Membre;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\SecurityBundle\Security;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(
        Request $request,
        AuthenticationUtils $authenticationUtils,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        Security $security
    ): Response {
        // Partie LOGIN
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
    
        // Partie REGISTER
        $user = new Membre();
        $registerForm = $this->createForm(RegistrationFormType::class, $user);
        $registerForm->handleRequest($request);
    
        $registerError = null;
        $isRegister = false;
    
        if ($registerForm->isSubmitted()) {
            $isRegister = true; // active le bon onglet
    
            if ($registerForm->isValid()) {
                $plainPassword = $registerForm->get('plainPassword')->getData();
    
                $user->setPassword(
                    $passwordHasher->hashPassword($user, $plainPassword)
                );
    
                $entityManager->persist($user);
                $entityManager->flush();
    
                // Connexion automatique (optionnel)
                $security->login($user);
    
                return $this->redirectToRoute('home');
            } else {
                $registerError = 'Please correct the errors in the form.';
            }
        }
    
        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'is_register' => $isRegister,
            'register_form' => $registerForm->createView(),
            'register_error' => $registerError,
        ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
