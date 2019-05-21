<?php

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController {
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
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
        $user = new User();

        // Create the form
        $form = $this->createForm(RegistrationType::class, $user);

        // Don't forget to call the request function to submit data to the db
        $form->handleRequest($request);

        // If form is submitted and valid, persist the data and flush
        if ($form->isSubmitted() && $form->isValid()){

            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Your account has been created! You can now log in!');

            return $this->redirectToRoute('account_login');
        }
        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/account/profile", name="account_profile")
     * @return Response
     */
    public function profile(Request $request, ObjectManager $manager){
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);

        // We make sure the infors are correct and we persist then flush again
        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Your informations have been modified');
        }

        return $this->render('account/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/account/password-update", name="account_password")
     * @return Response
     */
    public function updatePassword() {

        $passwordUpdate = new PasswordUpdate();
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
