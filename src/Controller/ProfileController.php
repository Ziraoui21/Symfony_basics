<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    public $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/profile', name: 'app_profile', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    #[Route('/profile/image/update', name: 'app_profile_update', methods: ['POST'])]
    public function update_image(Request $request): Response
    {
        $image = $request->files->get("image");
        $image_name = $image->getClientOriginalName();
        $image->move($this->getParameter("public_directory"), $image_name);

        $user = $this->getUser();
        $user->setImage($image_name);

        $entityManager = $this->doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success','image updated successfuly');

        return $this->redirectToRoute('app_profile');
    }
}
