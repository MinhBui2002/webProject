<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $UserEmail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $UserPassword;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $UserRole;

    /**
     * @ORM\OneToOne(targetEntity=UserDetail::class, inversedBy="user", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $userDetail;

    /**
     * @ORM\OneToMany(targetEntity=Order::class, mappedBy="User")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserEmail(): ?string
    {
        return $this->UserEmail;
    }

    public function setUserEmail(string $UserEmail): self
    {
        $this->UserEmail = $UserEmail;

        return $this;
    }

    public function getUserPassword(): ?string
    {
        return $this->UserPassword;
    }

    public function setUserPassword(string $UserPassword): self
    {
        $this->UserPassword = $UserPassword;

        return $this;
    }

    public function getUserRole(): ?string
    {
        return $this->UserRole;
    }

    public function setUserRole(string $UserRole): self
    {
        $this->UserRole = $UserRole;

        return $this;
    }

    public function getUserDetail(): ?UserDetail
    {
        return $this->userDetail;
    }

    public function setUserDetail(UserDetail $userDetail): self
    {
        $this->userDetail = $userDetail;

        return $this;
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUser($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getUser() === $this) {
                $order->setUser(null);
            }
        }

        return $this;
    }
}
