<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('product-create', name: 'product_create')]
    public function create(Request $request): JsonResponse
    {
        $requestData=json_decode($request->getContent(),true);


        $product = new Product();
        $product->setPrice($requestData['price']);
        $product->setName($requestData['name']);
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        return new JsonResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('product-read', name: 'read')]
    public function read(Request $request): JsonResponse
    {
        $products=$this->entityManager->getRepository(Product::class)->findAll();
        $tmpResponse=null;
        /** @var  $product */
        foreach ($products as $product){
            $tmpResponse[]=[
                "name"=>$product->getName(),
                "price"=>$product->getPrice(),
            ];

        }
        return new JsonResponse();
    }


    #[Route('product/{id}', name: 'product_get_item')]
    public function getItem(string $id): JsonResponse
    {
        $product=$this->entityManager->getRepository(Product::class)->find($id);
        return new JsonResponse($product);
    }

    #[Route('product_update/{id}', name: 'product_update_item')]
    public function updateProduct(string $id): JsonResponse
    {
        $product=$this->entityManager->getRepository(Product::class)->find($id);
        $product->setName("New name");
        $this->entityManager->flush();
        return new JsonResponse($product);
    }

    #[Route('product_delete/{id}', name: 'product_delete_item')]
    public function deleteProduct(string $id): JsonResponse
    {
        $product=$this->entityManager->getRepository(Product::class)->find($id);
        $this->entityManager->remove($product);
        $this->entityManager->flush();
        return new JsonResponse($product);
    }

}
