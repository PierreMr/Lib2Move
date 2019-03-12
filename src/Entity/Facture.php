<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactureRepository")
 */
class Facture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="factures")
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $user_email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $user_lastname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $user_firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $user_address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $user_phone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vehicule", inversedBy="factures")
     */
    private $vehicule_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $vehicule_name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $vehicule_km;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $brand;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $serie;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $licence_plate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Contrat", inversedBy="factures")
     */
    private $contract_id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contract_name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $max_time;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $max_km;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $km_penalty;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $time_penalty;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city_name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $start;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $end;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $end_final;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $end_diff;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $km_final;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $km_diff;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $time_final;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $pdf;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tva;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $final_price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="factures")
     */
    private $location_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContractName(): ?string
    {
        return $this->contract_name;
    }

    public function setContractName(?string $contract_name): self
    {
        $this->contract_name = $contract_name;

        return $this;
    }

    public function getMaxTime(): ?\DateTimeInterface
    {
        return $this->max_time;
    }

    public function setMaxTime(?\DateTimeInterface $max_time): self
    {
        $this->max_time = $max_time;

        return $this;
    }

    public function getMaxKm(): ?float
    {
        return $this->max_km;
    }

    public function setMaxKm(?float $max_km): self
    {
        $this->max_km = $max_km;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getKmPenalty(): ?float
    {
        return $this->km_penalty;
    }

    public function setKmPenalty(?float $km_penalty): self
    {
        $this->km_penalty = $km_penalty;

        return $this;
    }

    public function getTimePenalty(): ?float
    {
        return $this->time_penalty;
    }

    public function setTimePenalty(?float $time_penalty): self
    {
        $this->time_penalty = $time_penalty;

        return $this;
    }

    public function getCityName(): ?string
    {
        return $this->city_name;
    }

    public function setCityName(?string $city_name): self
    {
        $this->city_name = $city_name;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(?\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getVehiculeName(): ?string
    {
        return $this->vehicule_name;
    }

    public function setVehiculeName(string $vehicule_name): self
    {
        $this->vehicule_name = $vehicule_name;

        return $this;
    }

    public function getVehiculeKm(): ?int
    {
        return $this->vehicule_km;
    }

    public function setVehiculeKm(?int $vehicule_km): self
    {
        $this->vehicule_km = $vehicule_km;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->user_email;
    }

    public function setUserEmail(?string $user_email): self
    {
        $this->user_email = $user_email;

        return $this;
    }

    public function getUserLastname(): ?string
    {
        return $this->user_lastname;
    }

    public function setUserLastname(?string $user_lastname): self
    {
        $this->user_lastname = $user_lastname;

        return $this;
    }

    public function getUserFirstname(): ?string
    {
        return $this->user_firstname;
    }

    public function setUserFirstname(?string $user_firstname): self
    {
        $this->user_firstname = $user_firstname;

        return $this;
    }

    public function getUserAddress(): ?string
    {
        return $this->user_address;
    }

    public function setUserAddress(?string $user_address): self
    {
        $this->user_address = $user_address;

        return $this;
    }

    public function getUserPhone(): ?string
    {
        return $this->user_phone;
    }

    public function setUserPhone(?string $user_phone): self
    {
        $this->user_phone = $user_phone;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getSerie(): ?string
    {
        return $this->serie;
    }

    public function setSerie(?string $serie): self
    {
        $this->serie = $serie;

        return $this;
    }

    public function getLicencePlate(): ?string
    {
        return $this->licence_plate;
    }

    public function setLicencePlate(?string $licence_plate): self
    {
        $this->licence_plate = $licence_plate;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getVehiculeId(): ?Vehicule
    {
        return $this->vehicule_id;
    }

    public function setVehiculeId(?Vehicule $vehicule_id): self
    {
        $this->vehicule_id = $vehicule_id;

        return $this;
    }

    public function getContractId(): ?Contrat
    {
        return $this->contract_id;
    }

    public function setContractId(?Contrat $contract_id): self
    {
        $this->contract_id = $contract_id;

        return $this;
    }

    public function getLocationId(): ?Location
    {
        return $this->location_id;
    }

    public function setLocationId(?Location $location_id): self
    {
        $this->location_id = $location_id;

        return $this;
    }

    public function getPdf(): ?string
    {
        return $this->pdf;
    }

    public function setPdf(?string $pdf): self
    {
        $this->pdf = $pdf;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(?float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getFinalPrice(): ?float
    {
        return $this->final_price;
    }

    public function setFinalPrice(?float $final_price): self
    {
        $this->final_price = $final_price;

        return $this;
    }

    public function getEndFinal(): ?\DateTimeInterface
    {
        return $this->end_final;
    }

    public function setEndFinal(?\DateTimeInterface $end_final): self
    {
        $this->end_final = $end_final;

        return $this;
    }

    public function getEndDiff(): ?int
    {
        return $this->end_diff;
    }

    public function setEndDiff(?int $end_diff): self
    {
        $this->end_diff = $end_diff;

        return $this;
    }

    public function getKmFinal(): ?float
    {
        return $this->km_final;
    }

    public function setKmFinal(?float $km_final): self
    {
        $this->km_final = $km_final;

        return $this;
    }

    public function getKmDiff(): ?float
    {
        return $this->km_diff;
    }

    public function setKmDiff(?float $km_diff): self
    {
        $this->km_diff = $km_diff;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

}
