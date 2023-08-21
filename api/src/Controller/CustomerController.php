<?php

namespace App\Controller;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/customer-create', name: 'customer_create')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset(
            $requestData['first_name'],
            $requestData['last_name'],
            $requestData['phone_number']
        )) {
            throw new Exception("Invalid request data");
        }

        $customer = new Customer();

        $customer
            ->setFirstName($requestData['first_name'])
            ->setLastName($requestData['last_name'])
            ->setPhoneNumber($requestData['phone_number']);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        return new JsonResponse($customer, Response::HTTP_CREATED);
    }

    /**
     * @return JsonResponse
     */
    #[Route('/customer-all', name: 'customer_all')]
    public function getAll(): JsonResponse
    {
        $customers = $this->entityManager->getRepository(Customer::class)->findAll();

        return new JsonResponse($customers);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/customer/{id}', name: 'customer_get')]
    public function getCustomer(string $id): JsonResponse
    {
        $customer = $this->entityManager->getRepository(Customer::class)->find($id);

        if (!$customer) {
            throw new Exception("Customer with id " . $id . " not found");
        }

        return new JsonResponse($customer);
    }

    /**
     * @throws Exception
     */
    #[Route('/customer-update/{id}', name: 'customer_update')]
    public function updateCustomer(string $id, Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        /** @var Customer $customer */
        $customer = $this->entityManager->getRepository(Customer::class)->find($id);

        if (!$customer) {
            throw new Exception("Customer with id " . $id . " not found");
        }

        if (isset($requestData['first_name'])) {
            $customer->setFirstName($requestData['first_name']);
        }
        if (isset($requestData['last_name'])) {
            $customer->setLastName($requestData['last_name']);
        }
        if (isset($requestData['phone_number'])) {
            $customer->setPhoneNumber($requestData['phone_number']);
        }

        $this->entityManager->flush();

        return new JsonResponse($customer);
    }

    /**
     * @throws Exception
     */
    #[Route('/customer-delete/{id}', name: 'customer_delete')]
    public function deleteCustomer(string $id): JsonResponse
    {
        /** @var Customer $customer */
        $customer = $this->entityManager->getRepository(Customer::class)->find($id);

        if (!$customer) {
            throw new Exception("Customer with id " . $id . " not found");
        }

        $this->entityManager->remove($customer);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}