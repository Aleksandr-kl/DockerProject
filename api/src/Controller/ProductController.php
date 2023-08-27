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
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @return void
     */
    private function checkRoleAdmin(): void
    {
        if (!in_array(User::ROLE_ADMIN, $this->getUser()->getRoles())) {
            throw new NotFoundHttpException("Resource not found");
        }
    }

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

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('product-create', name: 'product_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        if (!in_array(User::ROLE_ADMIN, $this->getUser()->getRoles())) {
            throw new AccessDeniedHttpException("You do not have permission.");
        }

        $requestData = json_decode($request->getContent(), true);

        if (!isset(
            $requestData['name'],
            $requestData['count'],
            $requestData['price'],
            $requestData['category']
        )) {
            throw new Exception("Invalid request data");
        }

        $category = $this->entityManager->getRepository(Category::class)->find($requestData["category"]);

        if (!$category) {
            //throw new Exception("Category with id " . $requestData['category'] . " not found");
            throw new NotFoundHttpException("Category with id " . $requestData['category'] . " not found");
        }

        $product = new Product();

        $product
            ->setName($requestData['name'])
            ->setCount($requestData['count'])
            ->setPrice($requestData['price'])
            ->setCategory($category);

        $this->entityManager->persist($product);

        $this->entityManager->flush();

        return new JsonResponse($product, Response::HTTP_CREATED);
    }

    /**
     * @return JsonResponse
     */
    #[Route('product-all', name: 'product_all',methods: ['GET'])]
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

        $category = $this->entityManager->getRepository(Category::class)->find($requestData['category']);

        if (!$category) {
            throw new Exception("Category with id " . $requestData['category'] . " not found");
        }

        $product
            ->setName($requestData['name'])
            ->setCount($requestData['count'])
            ->setPrice($requestData['price'])
            ->setCategory($category);

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