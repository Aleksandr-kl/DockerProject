<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class ProductiInfo implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $info = null;
//    #[ORM\OneToOne(mappedBy: "productInfo", targetEntity: Product::class)]
//    private Product $product;

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getInfo(): ?string
    {
        return $this->info;
    }

    /**
     * @param string|null $info
     * @return $this
     */
    public function setInfo(?string $info): self
    {
        $this->info = $info;
        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return[
            "id"=>$this->getId(),
            "info"=>$this->getInfo()
        ];
    }
}