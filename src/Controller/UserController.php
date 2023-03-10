<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Image;
use App\Form\EditUserType;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if($form->isValid()){
                $user->setPassword($hasher->hashPassword($user, $user->getPassword()));
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('app_homepage');
            }
        }

        return $this->render('register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route("/logout", name:"app_logout")]
    public function logout(){

    }

    #[Route("/user/edit", name: "app_edit_user")]
    public function editUser(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher){

        $user = $this->getUser();
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($imageId = $form->get("image")->getData()){
                $imageRepository = $em->getRepository(Image::class);
                $user->setImage($imageRepository->find($imageId));
            }
            if($user->getPlainPassword()){
                $user->setPassword($hasher->hashPassword($user,$user->getPlainPassword()));
            }
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_homepage');
        }

        return $this->render('edit_user.html.twig', [
            'form' => $form->createView(),
        ]);

    }
}