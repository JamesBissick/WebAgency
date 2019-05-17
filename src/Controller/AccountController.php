<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     * @return Response
     */
    public function login(AuthenticationUtils $utils) {

        $error = $utils->getLastAuthenticationError();
        // Keep last username entered in variable $username for re-use
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $error !== NULL,
            'username' => $username // Keep the last entered username so the user won't have to re-enter it
        ]);
    }

    /**
     * You can log out
     * @Route("/logout", name="account_logout")
     * @return void
     */
    public function logout() {
        // nothing! Symfony does it on its own just indicate the route
    }

    /**
     * Displays the inscription form
     *
     * @Route("/register", name="account_register")
     * @return Response
     */
    public function register() {
        $user = new User();

        $form =  $this->createForm(RegistrationType::class, $user);

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
