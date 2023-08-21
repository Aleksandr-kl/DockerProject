<?php

namespace App\Entity;

use App\Repository\TypeServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: TypeServiceRepository::class)]
class TypeService implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $price = null;
    /**
     * @var Collection
     */
    #[ORM\OneTomany(mappedBy: "typeService", targetEntity: DetailService::class)]
    private Collection $services;

    /**
     * @return ArrayCollection|Collection
     */
    public function getServices(): ArrayCollection|Collection
    {
        return $this->services;
    }

    /**
     * @param ArrayCollection|Collection $services
     * @return void
     */
    public function setServices(ArrayCollection|Collection $services): void
    {
        $this->services = $services;
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

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
     * @return array
     */
    public function jsonSerialize():array
    {
        return [
            "id"=>$this->getId(),
            "name"=>$this->getName(),
            "price"=>$this->getPrice(),
            "service"=>$this->getServices()
        ];
    }
}
