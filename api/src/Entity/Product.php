<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Action\CreateProductAction;
use App\EntityListener\ProductEntityListener;
use App\Repository\ProductRepository;
use App\Validator\Constraints\Product as ProductConstraint;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
//#[ProductConstraint]
#[ApiResource(collectionOperations: [
    "get" => [
        "method" => "GET",
        "security" => "is_granted ('ROLE_ADMIN') or is_granted ('ROLE_USER')",
        "normalization_context" => ["groups" => ["get:collection:product"]]
    ],
    "post" => [
        "method" => "POST",
        "security" => "is_granted ('ROLE_ADMIN')",
        "denormalization_context" => ["groups" => ["post:collection:product"]],
        "normalization_context" => ["groups" => ["get:collection:product"]],
        "controller"=>CreateProductAction::class
    ]
],
    itemOperations: [
        "get" => [
            "method" => "GET",
            "normalization_context" => ["groups" => ["get:item:product"]]
        ],
        "put" => [
            "method" => "PUT"
        ],
        "delete" => [
            "method" => "DELETE"
        ]

    ],
    attributes: [
        "security" => "is_granted ('" . User::ROLE_ADMIN . "')"
    ]

)]
#[ApiFilter(SearchFilter::class, properties: ["name" => "exact", "description"])]
#[ApiFilter(RangeFilter::class, properties: ["price"])]
#[ORM\EntityListeners([ProductEntityListener::class])]
class Product
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        "get:item:product"
    ])]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[NotBlank]
    #[Groups([
        "get:collection:product",
        "get:item:product",
        "post:collection:product"
    ])]
    private ?string $name = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[NotBlank] #[Groups([
        "get:item:product",
        "post:collection:product"
    ])]
    private ?string $description = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    #[Groups([
        "get:item:product",
        "post:collection:product"
    ])]
    private ?int $count = null;

    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    #[Groups([
        "get:item:product",
        "post:collection:product"
    ])]
    private ?string $price = null;

    /**
     * @var Category|null
     */
    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: "products")]
    #[Groups([
        "get:item:product",
        "post:collection:product"
    ])]
    private ?Category $category = null;

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     * @return $this
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;
        return $this;
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
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCount(): ?int
    {
        return $this->count;
    }

    /**
     * @param int $count
     * @return $this
     */
    public function setCount(int $count): self
    {
        $this->count = $count;

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
    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }
//
//    /**
//     * @return array
//     */
//    public function jsonSerialize(): array
//    {
//        return [
//            "id" => $this->getId(),
//            "name" => $this->getName(),
//            "price" => $this->getPrice(),
//            "count" => $this->getCount(),
//            "description" => $this->getDescription()
//        ];
//    }
}
