<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SponsorshipCodeRepository")
 */
class SponsorshipCode
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sponsorshipCode;

    /**
     * @ORM\Column(type="boolean")
     */
    private $sponsorshipchecked;

    /**
     * @ORM\Column(type="integer")
     */
    private $childNumber;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     */
    private $partnership;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSponsorshipCode(): ?string
    {
        return $this->sponsorshipCode;
    }

    public function setSponsorshipCode(?string $sponsorshipCode): self
    {
        $this->sponsorshipCode = $sponsorshipCode;

        return $this;
    }

    public function getSponsorshipchecked(): ?bool
    {
        return $this->sponsorshipchecked;
    }

    public function setSponsorshipchecked(bool $sponsorshipchecked): self
    {
        $this->sponsorshipchecked = $sponsorshipchecked;

        return $this;
    }

    public function getChildNumber(): ?int
    {
        return $this->childNumber;
    }

    public function setChildNumber(int $childNumber): self
    {
        $this->childNumber = $childNumber;

        return $this;
    }

    public function getPartnership(): ?User
    {
        return $this->partnership;
    }

    public function setPartnership(?User $partnership): self
    {
        $this->partnership = $partnership;

        return $this;
    }
}
