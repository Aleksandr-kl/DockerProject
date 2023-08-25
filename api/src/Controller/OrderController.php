<?php

namespace App\Controller;

use App\Entity\Order;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class OrderController extends AbstractController
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

    /**
     * @return JsonResponse
     */
    #[Route('/order', name: 'app_order')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/OrderController.php',
        ]);
    }

    /**
     * @param string $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('order/{id}', name: 'order_get_item')]
    public function getItem(string $id): JsonResponse
    {
        $order = $this->entityManager->getRepository(Order::class)->find($id);

        if (!$order) {
            throw new Exception("Product with id " . $id . " not found");
        }

        return new JsonResponse($order);
    }
    /**
     * @param int $id
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('order-delete/{id}', name: 'order_delete_item')]
    public function deleteOrder(int $id): JsonResponse
    {
        $order = $this->entityManager->getRepository(Order::class)->find($id);

        if (!$order) {
            //return $this->json(['message' => 'Order not found'], 404);
            throw new Exception("Order with id " . $id . " not found");
        }

        $this->entityManager->remove($order);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
