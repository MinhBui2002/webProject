<?php

namespace App\Entity;

use App\Repository\UserDetailRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserDetailRepository::class)
 */
class UserDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $UserName;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $UserPhonenum;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $UserAddress;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="userDetail", cascade={"persist", "remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserName(): ?string
    {
        return $this->UserName;
    }

    public function setUserName(string $UserName): self
    {
        $this->UserName = $UserName;

        return $this;
    }

    public function getUserPhonenum(): ?string
    {
        return $this->UserPhonenum;
    }

    public function setUserPhonenum(string $UserPhonenum): self
    {
        $this->UserPhonenum = $UserPhonenum;

        return $this;
    }

    public function getUserAddress(): ?string
    {
        return $this->UserAddress;
    }

    public function setUserAddress(?string $UserAddress): self
    {
        $this->UserAddress = $UserAddress;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        // set the owning side of the relation if necessary
        if ($user->getUserDetail() !== $this) {
            $user->setUserDetail($this);
        }

        $this->user = $user;

        return $this;
    }
}
