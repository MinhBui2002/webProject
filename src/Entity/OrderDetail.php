<?php

namespace App\Entity;

use App\Repository\OrderDetailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderDetailRepository::class)
 */
class OrderDetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $DetailPrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $DetailQuantity;

    /**
     * @ORM\Column(type="float")
     */
    private $DetailTotal;

    /**
     * @ORM\OneToOne(targetEntity=Order::class, inversedBy="orderDetail", cascade={"persist", "remove"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $OrderEntity;

    /**
     * @ORM\ManyToMany(targetEntity=Product::class, inversedBy="orderDetails")
     */
    private $Product;

    
    public function __construct()
    {
        $this->Product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDetailPrice(): ?float
    {
        return $this->DetailPrice;
    }

    public function setDetailPrice(float $DetailPrice): self
    {
        $this->DetailPrice = $DetailPrice;

        return $this;
    }

    public function getDetailQuantity(): ?int
    {
        return $this->DetailQuantity;
    }

    public function setDetailQuantity(int $DetailQuantity): self
    {
        $this->DetailQuantity = $DetailQuantity;

        return $this;
    }

    public function getDetailTotal(): ?float
    {
        return $this->DetailTotal;
    }

    public function setDetailTotal(float $DetailTotal): self
    {
        $this->DetailTotal = $DetailTotal;

        return $this;
    }

    public function getOrderEntity(): ?Order
    {
        return $this->OrderEntity;
    }

    public function setOrderEntity(Order $OrderEntity): self
    {
        $this->OrderEntity = $OrderEntity;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProduct(): Collection
    {
        return $this->Product;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->Product->contains($product)) {
            $this->Product[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        $this->Product->removeElement($product);

        return $this;
    }

    
}
