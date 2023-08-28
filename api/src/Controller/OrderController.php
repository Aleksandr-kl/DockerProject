<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\OrderRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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
    #[Route('order-all', name: 'order_list', methods: ['GET'])]
    public function listOrders(): JsonResponse
    {
        if (!in_array(User::ROLE_ADMIN, $this->getUser()->getRoles())) {
            throw new AccessDeniedHttpException("You do not have permission.");
        }

        $orders = $this->entityManager->getRepository(Order::class)->findAll();

        return new JsonResponse($orders);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    #[Route('order/{id}', name: 'order_show', methods: ['GET'])]
    public function showOrder(string $id): JsonResponse
    {
        $order = $this->entityManager->getRepository(Order::class)->find($id);

        if (!$order) {
            return new JsonResponse(["message" => "Order with id " . $id . " not found"], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($order);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('order-create', name: 'order_create', methods: ['POST'])]
    public function createOrder(Request $request): JsonResponse
    {
        if (!in_array(User::ROLE_USER, $this->getUser()->getRoles())) {
            throw new AccessDeniedHttpException("You do not have permission.");
        }

        return $this->json (); //($order, Response::HTTP_CREATED);

    }

    /**
     * @param Request $request
     * @param string $id
     * @return JsonResponse
     */
    #[Route('order-update/{id}', name: 'order_update', methods: ['PUT'])]
    public function updateOrder(Request $request, string $id): JsonResponse
    {
        if (!in_array(User::ROLE_USER, $this->getUser()->getRoles())) {
            throw new AccessDeniedHttpException("You do not have permission.");
        }
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
     * @param string $id
     * @return JsonResponse
     */
    #[Route('order-delete/{id}', name: 'order_delete', methods: ['DELETE'])]
    public function deleteOrder(string $id): JsonResponse
    {
        if (!in_array(User::ROLE_USER, $this->getUser()->getRoles())) {
            throw new AccessDeniedHttpException("You do not have permission.");
        }
        $order = $this->orderRepository->find($id);

        if (!$order) {
            return new JsonResponse(['error' => 'Order not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($order);
        $this->entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}
