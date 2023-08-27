<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order implements JsonSerializable
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    /**
     * @var int|null
     */
    #[ORM\Column]
    private ?int $count = null;
    /**
     * @var string|null
     */
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0')]
    private ?string $summa = null;

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return void
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
    /**
     * @var User|null
     */
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "orders")]
    private ?User $user = null;

    /**
     * @return Collection
     */
    public function getProduct(): Collection
    {
        return $this->products;
    }

    /**
     * @param Collection $products
     * @return void
     */
    public function setProduct(Collection $products): void
    {
        $this->products = $products;
    }

    /**
     * @var Collection
     */
    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'order')]
    private Collection $products;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
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
    public function getSumma(): ?string
    {
        return $this->summa;
    }

    /**
     * @param string $summa
     * @return $this
     */
    public function setSumma(string $summa): self
    {
        $this->summa = $summa;

        return $this;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            "id"      => $this->getId(),
            "count"   => $this->getCount(),
            "summa"   => $this->getSumma(),
            "user"    => $this->getUser(),
            "product" => $this->getProduct()
        ];
    }
}
