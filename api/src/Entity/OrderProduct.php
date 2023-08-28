<?php

namespace App\Entity;

use App\Repository\OrderProductRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: OrderProductRepository::class)]
class OrderProduct implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @var Order|null
     */
    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: "orderProducts")]
    private ?Order $order = null;

    /**
     * @var Product|null
     */
    #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: "orderProducts")]
    private ?Product $product = null;

    /**
     * @return Order|null
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * @param Order|null $order
     * @return void
     */
    public function setOrder(?Order $order): void
    {
        $this->order = $order;
    }

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product|null $product
     * @return void
     */
    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return array
     */
    public function jsonSerialize():array
    {
        return [
            "id" => $this->getId(),
            "order_id" => $this->getOrder(),
            "product_id" => $this->getProduct(),
        ];
    }
}
