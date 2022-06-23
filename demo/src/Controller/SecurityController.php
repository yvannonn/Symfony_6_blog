<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class SecurityController extends AbstractController
{

    #[Route('/inscription', name: 'security_registration')]
    public function registration(Request $request, ObjectManager $manager, UserPasswordHasherInterface $encoder)
    {

        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();
            $this->redirectToRoute('security_login');
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/connexion', name: 'security_login')]
    public function login(Request $request, ObjectManager $manager)
    {

        return $this->render('security/login.html.twig');
    }


    #[Route('/deconnexion', name: 'security_logout')]
    public function logout()
    {
    }



    /*#[Route('/security', name: 'app_security')]
    public function index(): Response
    {
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }*/
}
