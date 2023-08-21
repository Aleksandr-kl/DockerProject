<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(length: 255)]
    private ?string $position = null;

    #[ORM\Column(length: 255)]
    private ?string $phone_number = null;
    /**
     * @var Collection
     */
    #[ORM\OneTomany(mappedBy: "employee", targetEntity: Order::class)]
    private Collection $orders;

    /**
     * @return Collection
     */
    public function getOrders(): Collection
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
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     * @return $this
     */
    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string $last_name
     * @return $this
     */
    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPosition(): ?string
    {
        return $this->position;
    }

    /**
     * @param string $position
     * @return $this
     */
    public function setPosition(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    /**
     * @param string $phone_number
     * @return $this
     */
    public function setPhoneNumber(string $phone_number): static
    {
        $this->phone_number = $phone_number;

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
