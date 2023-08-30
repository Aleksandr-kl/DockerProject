<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductController extends AbstractController
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @var DenormalizerInterface
     */
    private DenormalizerInterface $denormalizer;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     * @param DenormalizerInterface $denormalizer
     */
    public function __construct(EntityManagerInterface $entityManager,
                                ValidatorInterface     $validator,
                                DenormalizerInterface  $denormalizer)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->denormalizer = $denormalizer;
    }

    /**
     * @return void
     */
    private function checkRoleAdmin(): void
    {
        if (!in_array(User::ROLE_ADMIN, $this->getUser()->getRoles())) {
            throw new NotFoundHttpException("Resource not found");
        }
    }

//    /**
//     * @param Request $request
//     * @return JsonResponse
//     * @throws Exception
//     */
//    #[Route('product-create', name: 'product_create', methods: ['POST'])]
//    public function create(Request $request): JsonResponse
//    {
//        $this->checkRoleAdmin();
//
//        $requestData = json_decode($request->getContent(), true);
//
//        $product = $this->denormalizer->denormalize($requestData, Product::class, "array");
//
//        $errors = $this->validator->validate($product);
//
////        $category = $this->entityManager->getRepository(Category::class)->find($requestData["category"]);
////
////        if (!$category) {
////            throw new NotFoundHttpException("Category with id " . $requestData['category'] . " not found");
////        }
//
//        $product = new Product();
//
//        $product
//            ->setName($requestData['name'])
//            ->setCount($requestData['count'])
//            ->setPrice($requestData['price'])
//            ->setDescription($requestData['description']);
//
//        $this->entityManager->persist($product);
//
//        $this->entityManager->flush();
//
//        return new JsonResponse($product, Response::HTTP_CREATED);
//    }

    /**
     * @return JsonResponse
     */
    #[Route('product-all', name: 'product_all', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        return new JsonResponse($products);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('product/{id}', name: 'product_get_item', methods: ['GET'])]
    public function getItem(string $id): JsonResponse
    {
        $this->checkRoleAdmin();

        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            return new JsonResponse(["message" => "Product with id " . $id . " not found"], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($product);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('product-update/{id}', name: 'product_update_item', methods: ['PUT'])]
    public function updateProduct(string $id, Request $request): JsonResponse
    {
        $this->checkRoleAdmin();

        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw new Exception("Product with id " . $id . " not found");
        }

        $requestData = json_decode($request->getContent(), true);

        $product = $this->denormalizer->denormalize($requestData, Product::class, "array");

        $errors = $this->validator->validate($product);

        //$category = $this->entityManager->getRepository(Category::class)->find($requestData['category']);

//        if (!$category) {
//            throw new Exception("Category with id " . $requestData['category'] . " not found");
//        }

        $product
            ->setName($requestData['name'])
            ->setCount($requestData['count'])
            ->setPrice($requestData['price'])
            ->setDescription($requestData['description']);

        $this->entityManager->flush();

        return new JsonResponse($product);

    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('product-delete/{id}', name: 'product_delete_item', methods: ['PUT'])]
    public function deleteProduct(string $id): JsonResponse
    {
        $this->checkRoleAdmin();

        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw new Exception("Product with id " . $id . " not found");
        }

        foreach ($product->getOrders() as $order) {
            $order->getProduct()->removeElement($product);
        }

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}