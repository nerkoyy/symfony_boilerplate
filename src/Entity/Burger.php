<?php

namespace App\Entity;

use App\Repository\BurgerRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


#[ORM\Entity(repositoryClass: BurgerRepository::class)]
class Burger
{

    public function __construct()
    {
        $this->oignons = new ArrayCollection();
        $this->sauce = new ArrayCollection();
    }

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
    private $oignons;

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

    public function getPain(): ?Pain
    {
        return $this->pain;
    }

    public function setPain(Pain $pain): self
    {
        $this->pain = $pain;
        return $this;
    }

    public function setImage(Image $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function addSauce(Sauce $sauce): self
    {
        if (!$this->sauce->contains($sauce)) {
            $this->sauce[] = $sauce;
        }
        return $this;
    }


    public function getOignons(): Collection
    {
        return $this->oignons;
    }

    public function addOignon(Oignon $oignon): self
    {
        if (!$this->oignons->contains($oignon)) {
            $this->oignons[] = $oignon;
        }
        return $this;
    }

    public function removeOignon(Oignon $oignon): self
    {
        $this->oignons->removeElement($oignon);
        return $this;
    }
}
