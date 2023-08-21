<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @return ArrayCollection|Collection
     */
    public function getProducts(): ArrayCollection|Collection
    {
        return $this->products;
    }

    /**
     * @param ArrayCollection|Collection $products
     * @return void
     */
    public function setProducts(ArrayCollection|Collection $products): void
    {
        $this->products = $products;
    }

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: "category", targetEntity: Product::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

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

    public function jsonSerialize():array
    {
        return [
            "id"          => $this->getId(),
            "name"        => $this->getName(),
            "product" => $this->getProducts(),
        ];
    }
}
