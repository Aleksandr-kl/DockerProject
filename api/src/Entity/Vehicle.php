<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
class Vehicle implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    private ?string $win_code = null;

    /**
     * @var Customer|null
     */
    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: "vehicle")]
    private ?Customer $customer = null;
    #[ORM\OneTomany(mappedBy: "vehicle", targetEntity: Order::class)]
    private Collection $orders;

    /**
     * @return ArrayCollection|Collection
     */
    public function getOrders(): ArrayCollection|Collection
    {
        return $this->orders;
    }

    /**
     * @param ArrayCollection|Collection $orders
     * @return void
     */
    public function setOrders(ArrayCollection|Collection $orders): void
    {
        $this->orders = $orders;
    }
    /**
     * @return Customer|null
     */
    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    /**
     * @param Customer|null $customer
     * @return void
     */
    public function setCustomer(?Customer $customer): void
    {
        $this->customer = $customer;
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
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     * @return $this
     */
    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @param string $model
     * @return $this
     */
    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getWinCode(): ?string
    {
        return $this->win_code;
    }

    /**
     * @param string $win_code
     * @return $this
     */
    public function setWinCode(string $win_code): static
    {
        $this->win_code = $win_code;

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
