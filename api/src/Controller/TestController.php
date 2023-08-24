<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/test', name: 'test_test')]
    //#[IsGranted("ROLE_ADMIN")]
    public function test(Request $request): JsonResponse
    {
        $user = $this->getUser();

        $products=$this->entityManager->getRepository(Product::class)->findAll();

        if (in_array(User::ROLE_ADMIN, $user->getRoles())) {
            return new JsonResponse($products);
        }
        return new JsonResponse($this->fetchedProductsForUser($products));


    }

    /**
     * @param array $products
     * @return array
     */
    public function fetchedProductsForUser(array $products): array{
        /** @var Product $product */
        foreach ($products as  $product){
            $tmpProductData=$product->jsonSerialize();

            unset($tmpProductData['description']);
            $fetchedProductsForUser[]=$tmpProductData;
        }
        return $fetchedProductsForUser;
    }
}
