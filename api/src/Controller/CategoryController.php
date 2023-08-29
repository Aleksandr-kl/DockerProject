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

class CategoryController extends AbstractController
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
     * @var DenormalizerInterface
     */
    private DenormalizerInterface $denormalizer;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @param EntityManagerInterface $entityManager
     * @param DenormalizerInterface $denormalizer
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $entityManager,
                                DenormalizerInterface  $denormalizer,
                                ValidatorInterface     $validator)
    {
        $this->entityManager = $entityManager;
        $this->denormalizer = $denormalizer;
        $this->validator = $validator;

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('category-create', name: 'category_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $this->checkRoleAdmin();

        $requestData = json_decode($request->getContent(), true);

        $category = $this->denormalizer->denormalize($requestData, Category::class, "array");

        $errors = $this->validator->validate($category);

        $category = new Category();

        $category->setName($requestData['name']);

        $category->setType($requestData['type']);

        $this->entityManager->persist($category);

        $this->entityManager->flush();

        return new JsonResponse($category, Response::HTTP_CREATED);
    }

    /**
     * @return JsonResponse
     */
    #[Route('category-all', name: 'category_all', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        $category = $this->entityManager->getRepository(Category::class)->findAll();

        return new JsonResponse($category);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('category/{id}', name: 'category_get_item', methods: ['GET'])]
    public function getItem(string $id): JsonResponse
    {
        $this->checkRoleAdmin();

        $category = $this->entityManager->getRepository(Category::class)->find($id);

        if (!$category) {
            throw new Exception("Category with id " . $id . " not found");
        }

        return new JsonResponse($category);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('category-update/{id}', name: 'category_update_item', methods: ['PUT'])]
    public function updateCategory(string $id, Request $request): JsonResponse
    {
        $this->checkRoleAdmin();

        /** @var Category $category */
        $category = $this->entityManager->getRepository(Category::class)->find($id);

        $requestData = json_decode($request->getContent(), true);

        if (!$category) {
            throw new Exception("Category with id " . $id . " not found");
        }
        $category = $this->denormalizer->denormalize($requestData, Category::class, "array");

        $errors = $this->validator->validate($category);

        $category->setName("New name");

        $category->setType("New type");


        $this->entityManager->flush();

        return new JsonResponse($category);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('category-delete/{id}', name: 'category_delete_item', methods: ['PUT'])]
    public function deleteCategory(string $id): JsonResponse
    {
        $this->checkRoleAdmin();

        /** @var Category $category */
        $category = $this->entityManager->getRepository(Category::class)->find($id);

        if (!$category) {
            throw new Exception("Category with id " . $id . " not found");
        }

        $this->entityManager->remove($category);

        $this->entityManager->flush();

        return new JsonResponse();
    }

}
