<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContratRepository")
 */
class Contrat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeVehicule", inversedBy="contrats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_km;

    /**
     * @ORM\Column(type="time")
     */
    private $max_time;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="float")
     */
    private $km_penalty;

    /**
     * @ORM\Column(type="float")
     */
    private $time_penalty;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Location", mappedBy="contrat")
     */
    private $locations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Facture", mappedBy="contract_id")
     */
    private $factures;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->factures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?TypeVehicule
    {
        return $this->type;
    }

    public function setType(?TypeVehicule $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMaxKm(): ?int
    {
        return $this->max_km;
    }

    public function setMaxKm(int $max_km): self
    {
        $this->max_km = $max_km;

        return $this;
    }

    public function getMaxTime(): ?\DateTimeInterface
    {
        return $this->max_time;
    }

    public function setMaxTime(\DateTimeInterface $max_time): self
    {
        $this->max_time = $max_time;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getKmPenalty(): ?float
    {
        return $this->km_penalty;
    }

    public function setKmPenalty(float $km_penalty): self
    {
        $this->km_penalty = $km_penalty;

        return $this;
    }

    public function getTimePenalty(): ?float
    {
        return $this->time_penalty;
    }

    public function setTimePenalty(float $time_penalty): self
    {
        $this->time_penalty = $time_penalty;

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setContrat($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
            // set the owning side to null (unless already changed)
            if ($location->getContrat() === $this) {
                $location->setContrat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Facture[]
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures[] = $facture;
            $facture->setContractId($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->contains($facture)) {
            $this->factures->removeElement($facture);
            // set the owning side to null (unless already changed)
            if ($facture->getContractId() === $this) {
                $facture->setContractId(null);
            }
        }

        return $this;
    }
}
