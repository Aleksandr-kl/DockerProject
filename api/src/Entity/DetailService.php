<?php

namespace App\Entity;

use App\Repository\DetailServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: DetailServiceRepository::class)]
class DetailService implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $price = null;
    /**
     * @var Order|null
     */
    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: "detailService")]
    private ?Order $order = null;
    /**
     * @var TypeService|null
     */
    #[ORM\ManyToOne(targetEntity: TypeService::class, inversedBy: "detailService")]
    private ?TypeService $typeService = null;

    /**
     * @return TypeService|null
     */
    public function getTypeService(): ?TypeService
    {
        return $this->typeService;
    }

    /**
     * @param TypeService|null $typeService
     * @return void
     */
    public function setTypeService(?TypeService $typeService): void
    {
        $this->typeService = $typeService;
    }



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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return $this
     */
    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return void
     */
    public function jsonSerialize()
    {
        // TODO: Implement jsonSerialize() method.
    }
}
