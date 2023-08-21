<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_accept = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;
    /**
     * @var Collection
     */
    #[ORM\OneTomany(mappedBy: "order", targetEntity: DetailService::class)]
    private Collection $detailServices;

    /**
     * @var Employee|null
     */
    #[ORM\ManyToOne(targetEntity: Employee::class, inversedBy: "order")]
    private ?Employee $employee = null;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: "order")]
    private ?Customer $customer = null;
    #[ORM\ManyToOne(targetEntity: Vehicle::class, inversedBy: "order")]
    private ?Vehicle $vehicle = null;

    /**
     * @return Vehicle|null
     */
    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    /**
     * @param Vehicle|null $vehicle
     * @return void
     */
    public function setVehicle(?Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;
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
     * @return ArrayCollection|Collection
     */
    public function getDetailServices(): ArrayCollection|Collection
    {
        return $this->detailServices;
    }

    /**
     * @param ArrayCollection|Collection $detailServices
     * @return void
     */
    public function setDetailServices(ArrayCollection|Collection $detailServices): void
    {
        $this->detailServices = $detailServices;
    }

    /**
     * @return Employee|null
     */
    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    /**
     * @param Employee|null $employee
     * @return void
     */
    public function setEmployee(?Employee $employee): void
    {
        $this->employee = $employee;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getDateAccept(): ?\DateTimeInterface
    {
        return $this->date_accept;
    }

    /**
     * @param \DateTimeInterface $date_accept
     * @return $this
     */
    public function setDateAccept(\DateTimeInterface $date_accept): static
    {
        $this->date_accept = $date_accept;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): static
    {
        $this->status = $status;

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
