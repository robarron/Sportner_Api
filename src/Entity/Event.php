<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $organizer;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $place;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sportType;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $interestedNumber;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $participateNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ticketingSiteLink;

    /**
     * @ORM\Column(type="string", length=65000, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isTopEvent;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getOrganizer(): ?string
    {
        return $this->organizer;
    }

    public function setOrganizer(?string $organizer): self
    {
        $this->organizer = $organizer;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getSportType(): ?string
    {
        return $this->sportType;
    }

    public function setSportType(?string $sportType): self
    {
        $this->sportType = $sportType;

        return $this;
    }

    public function getInterestedNumber(): ?int
    {
        return $this->interestedNumber;
    }

    public function setInterestedNumber(?int $interestedNumber): self
    {
        $this->interestedNumber = $interestedNumber;

        return $this;
    }

    public function getParticipateNumber(): ?int
    {
        return $this->participateNumber;
    }

    public function setParticipateNumber(?int $participateNumber): self
    {
        $this->participateNumber = $participateNumber;

        return $this;
    }

    public function getTicketingSiteLink(): ?string
    {
        return $this->ticketingSiteLink;
    }

    public function setTicketingSiteLink(?string $ticketingSiteLink): self
    {
        $this->ticketingSiteLink = $ticketingSiteLink;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getIsTopEvent(): ?bool
    {
        return $this->isTopEvent;
    }

    public function setIsTopEvent(bool $isTopEvent): self
    {
        $this->isTopEvent = $isTopEvent;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }
}
