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
use Symfony\Component\Serializer\Normalizer\DenormalizableInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TestController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    private UserPasswordHasherInterface $passwordHasher;
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;
    /**
     * @var DenormalizerInterface
     */
    private DenormalizerInterface $denormalizer;

    public function __construct( EntityManagerInterface $entityManager, DenormalizerInterface $denormalizer)
    {
       // $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->de=$denormalizer;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/test', name: 'test_test')]
    //#[IsGranted("ROLE_ADMIN")]
    public function test(Request $request): Response
    {
       $user = $this->getUser();
//
//        $products=$this->entityManager->getRepository(Product::class)->findAll();
//
//        if (in_array(User::ROLE_ADMIN, $user->getRoles())) {
//            return new JsonResponse($products);
//        }
        $requestData=json_decode($request->getContent(),true);
        $product=$this->denormalizer->denormalize($requestData,Product::class,"array");
        $errors=$this->validator->validate($product);
        if(count($errors)>0){
            return new JsonResponse((string)$errors);
        }
        return new JsonResponse();




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

    public function getPasswordHasher(): UserPasswordHasherInterface
    {
        return $this->passwordHasher;
    }

    public function setPasswordHasher(UserPasswordHasherInterface $passwordHasher): void
    {
        $this->passwordHasher = $passwordHasher;
    }
}
