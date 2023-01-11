<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private $doctrine;
    private $passwordEncoder;

    public function __construct(ManagerRegistry $doctrine,UserPasswordHasherInterface $passwordEncoder)
    {
        $this->doctrine = $doctrine;
        $this->passwordEncoder = $passwordEncoder;
    }

    #[Route('/register', name: 'app_register', methods: ['GET','POST'])]
    public function index(Request $request): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('app_product');
        // }

        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user = $form->getData();
            $password = $this->passwordEncoder->hashPassword($user,$user->getPassword());
            $user->setPassword($password);

            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('register/index.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
