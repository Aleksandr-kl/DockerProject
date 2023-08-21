<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\Vehicle;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehicleController extends AbstractController
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
    #[Route('/vehicle-create', name: 'vehicle_create')]
    public function create(Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        if (!isset(
            $requestData['brand'],
            $requestData['model'],
            $requestData['win_code'],
            $requestData['customer']
        )) {
            throw new Exception("Invalid request data");
        }

        $vehicle = new Vehicle();

        $vehicle
            ->setBrand($requestData['brand'])
            ->setModel($requestData['model'])
            ->setWinCode($requestData['win_code'])
            ->setCustomer($this->entityManager->getRepository(Customer::class)->find($requestData['customer']));

        $this->entityManager->persist($vehicle);
        $this->entityManager->flush();

        return new JsonResponse($vehicle, Response::HTTP_CREATED);
    }

    #[Route('/vehicle-all', name: 'vehicle_all')]
    public function getAll(): JsonResponse
    {
        $vehicles = $this->entityManager->getRepository(Vehicle::class)->findAll();

        return new JsonResponse($vehicles);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/vehicle/{id}', name: 'vehicle_get')]
    public function getVehicle(string $id): JsonResponse
    {
        $vehicle = $this->entityManager->getRepository(Vehicle::class)->find($id);

        if (!$vehicle) {
            throw new Exception("Vehicle with id " . $id . " not found");
        }

        return new JsonResponse($vehicle);
    }

    /**
     * @param string $id
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/vehicle-update/{id}', name: 'vehicle_update')]
    public function updateVehicle(string $id, Request $request): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        /** @var Vehicle $vehicle */
        $vehicle = $this->entityManager->getRepository(Vehicle::class)->find($id);

        if (!$vehicle) {
            throw new Exception("Vehicle with id " . $id . " not found");
        }

        if (isset($requestData['brand'])) {
            $vehicle->setBrand($requestData['brand']);
        }
        if (isset($requestData['model'])) {
            $vehicle->setModel($requestData['model']);
        }
        if (isset($requestData['win_code'])) {
            $vehicle->setWinCode($requestData['win_code']);
        }

        $this->entityManager->flush();

        return new JsonResponse($vehicle);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     *
     */
    #[Route('/vehicle-delete/{id}', name: 'vehicle_delete')]
    public function deleteVehicle(string $id): JsonResponse
    {
        /** @var Vehicle $vehicle */
        $vehicle = $this->entityManager->getRepository(Vehicle::class)->find($id);

        if (!$vehicle) {
            throw new Exception("Vehicle with id " . $id . " not found");
        }

        $this->entityManager->remove($vehicle);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
