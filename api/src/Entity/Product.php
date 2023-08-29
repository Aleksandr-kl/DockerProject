<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use App\Validator\Constraints\Product as ProductConstraint;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
//#[ProductConstraint]
#[ApiResource(collectionOperations: [
    "get" => [
        "method" => "GET",
        "security" => "is_granted ('ROLE_ADMIN') or is_granted ('ROLE_USER')"
    ]
],
    itemOperations: [
        "get" => [
            "method" => "GET"
        ]
    ],
    attributes: [
        "security"=>"is_granted ('".User::ROLE_ADMIN ."')"
    ]

)]
class Product implements JsonSerializable
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[NotBlank]
    private ?string $name = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $count = null;
    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $price = null;

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

    /**
     * @return array
     */

    public function jsonSerialize(): array
    {
        return [
            "id" => $this->getId(),
            "name" => $this->getName(),
            "price" => $this->getPrice()
        ];
    }
}
