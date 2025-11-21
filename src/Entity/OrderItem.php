<?php

namespace App\Entity;

use App\Repository\OrderItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderItemRepository::class)]
class OrderItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantiter = null;

    #[ORM\Column]
    private ?float $prixAchat = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $orders = null;

    #[ORM\ManyToOne(inversedBy: 'orderItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiter(): ?int
    {
        return $this->quantiter;
    }

    public function setQuantiter(int $quantiter): static
    {
        $this->quantiter = $quantiter;

        return $this;
    }

    public function getPrixAchat(): ?float
    {
        return $this->prixAchat;
    }

    public function setPrixAchat(float $prixAchat): static
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }

    public function getOrders(): ?Order
    {
        return $this->orders;
    }

    public function setOrders(?Order $orders): static
    {
        $this->orders = $orders;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
