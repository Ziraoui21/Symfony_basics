<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    private $productRepository;
    private $doctrine;

    public function __construct(ProductRepository $productRepository,ManagerRegistry $doctrine)
    {
        $this->productRepository = $productRepository;
        $this->doctrine = $doctrine;
    }
    
    #[Route('/', name: 'app_product', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $this->productRepository->findAll(),
        ]);
    }

    #[Route('/product/new', name: 'app_product_new', methods: ['GET','POST'])]
    #[IsGranted('ROLE_ADMIN',message:'no way')]
    public function new(Request $request)
    {
        $product = new Product();
        
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $product = $form->getData();
            $entityManager = $this->doctrine->getManager();

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product');
        }

        return $this->render('product/new.html.twig',[
            'form' => $form->createView()
        ]);   
    }

    #[Route('/product/edit/{id}', name: 'app_product_edit', methods: ['GET','POST'])]
    public function edit(Product $product,Request $request)
    {
        $form = $this->createForm(ProductType::class,$product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $product = $form->getData();
            $entityManager = $this->doctrine->getManager();

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product');
        }

        return $this->render('product/edit.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/product/detail/{id}', name: 'app_product_detail', methods: ['GET'])]
    public function detail($id)
    {
        return $this->render('product/detail.html.twig', [
            'product' => $this->productRepository->find($id),
        ]);
    }

    #[Route('/product/delete/{id}', name: 'app_product_delete', methods: ['GET'])]
    public function delete(Product $product)
    {
        $entityManager = $this->doctrine->getManager();
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('app_product');
    }
}
