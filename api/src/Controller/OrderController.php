<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class OrderController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var OrderRepository
     */
    private OrderRepository $orderRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param OrderRepository $orderRepository
     */
    public function __construct(EntityManagerInterface $entityManager, OrderRepository $orderRepository)
    {
        $this->entityManager = $entityManager;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return JsonResponse
     */
    #[Route('/orders', name: 'order_list', methods: ['GET'])]
    public function listOrders(): JsonResponse
    {
        $orders = $this->orderRepository->findAll();

        return $this->json($orders);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/orders/{id}', name: 'order_show', methods: ['GET'])]
    public function showOrder(int $id): JsonResponse
    {
        $order = $this->orderRepository->find($id);

        if (!$order) {
            return new JsonResponse(['error' => 'Order not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($order);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/orders', name: 'order_create', methods: ['POST'])]
    public function createOrder(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $order = new Order();
        $order->setCount($data['count']);
        $order->setSumma($data['summa']);
        $user = $this->getUser();
        $order->setUser($user);

        $this->entityManager->persist($order);
        $this->entityManager->flush();

        return $this->json($order, Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/orders/{id}', name: 'order_update', methods: ['PUT'])]
    public function updateOrder(Request $request, int $id): JsonResponse
    {
        $order = $this->orderRepository->find($id);

        if (!$order) {
            return new JsonResponse(['error' => 'Order not found'], Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $order->setCount($data['count']);
        $order->setSumma($data['summa']);

        $this->entityManager->flush();

        return $this->json($order);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    #[Route('/orders/{id}', name: 'order_delete', methods: ['DELETE'])]
    public function deleteOrder(int $id): JsonResponse
    {
        $order = $this->orderRepository->find($id);

        if (!$order) {
            return new JsonResponse(['error' => 'Order not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($order);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
