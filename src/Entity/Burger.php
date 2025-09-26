<?php

namespace App\Entity;

use App\Repository\BurgerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
class Burger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\ManyToOne(targetEntity: Pain::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $pain;

    #[ORM\ManyToMany(targetEntity: Oignon::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $oignon;

    #[ORM\ManyToMany(targetEntity: Sauce::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $sauce;

    #[ORM\OneToOne(targetEntity: Image::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $image;

    #[ORM\OneToMany(mappedBy:"burger", targetEntity: Commentaire::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $commentaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }
}
