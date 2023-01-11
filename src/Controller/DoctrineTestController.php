<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class DoctrineTestController extends AbstractController
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Route('/doctrine/test', name: 'app_doctrine_test', methods: ['GET'])]
    public function index()
    {
        // 'products' => $this->repository->findAll(),
        // 'between' => $this->repository->getProductsBetweenPrice(1,5)
        return $this->json([
            'products' => $this->repository->findAll()
        ]);
    }
}
