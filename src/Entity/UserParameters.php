<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserParametersRepository")
 */
class UserParameters
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="userParameters", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GenderSearch", inversedBy="UserParameters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $genderSearch;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $localisation = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $maxDistance;

    /**
     * @ORM\Column(type="integer")
     */
    private $minAgeSearch;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxAgeSearch;

    /**
     * @ORM\Column(type="boolean")
     */
    private $displayProfil;

    /**
     * @ORM\Column(type="boolean")
     */
    private $displayPic;

    /**
     * @ORM\Column(type="boolean")
     */
    private $displayMotivations;

    /**
     * @ORM\Column(type="boolean")
     */
    private $displayCaracSportives;

    /**
     * @ORM\Column(type="boolean")
     */
    private $displayDispo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $displayLevel;

    /**
     * @ORM\Column(type="boolean")
     */
    private $notifMatch;

    /**
     * @ORM\Column(type="boolean")
     */
    private $notifMessage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $notifMaj;

    /**
     * @ORM\Column(type="boolean")
     */
    private $MatchPush;

    /**
     * @ORM\Column(type="boolean")
     */
    private $MsgPush;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getGenderSearch(): ?GenderSearch
    {
        return $this->genderSearch;
    }

    public function setGenderSearch(?GenderSearch $genderSearch): self
    {
        $this->genderSearch = $genderSearch;

        return $this;
    }

    public function getLocalisation(): ?array
    {
        return $this->localisation;
    }

    public function setLocalisation(?array $localisation): self
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getMaxDistance(): ?int
    {
        return $this->maxDistance;
    }

    public function setMaxDistance(int $maxDistance): self
    {
        $this->maxDistance = $maxDistance;

        return $this;
    }

    public function getMinAgeSearch(): ?int
    {
        return $this->minAgeSearch;
    }

    public function setMinAgeSearch(int $minAgeSearch): self
    {
        $this->minAgeSearch = $minAgeSearch;

        return $this;
    }

    public function getMaxAgeSearch(): ?int
    {
        return $this->maxAgeSearch;
    }

    public function setMaxAgeSearch(int $maxAgeSearch): self
    {
        $this->maxAgeSearch = $maxAgeSearch;

        return $this;
    }

    public function getDisplayProfil(): ?bool
    {
        return $this->displayProfil;
    }

    public function setDisplayProfil(bool $displayProfil): self
    {
        $this->displayProfil = $displayProfil;

        return $this;
    }

    public function getDisplayPic(): ?bool
    {
        return $this->displayPic;
    }

    public function setDisplayPic(bool $displayPic): self
    {
        $this->displayPic = $displayPic;

        return $this;
    }

    public function getDisplayMotivations(): ?bool
    {
        return $this->displayMotivations;
    }

    public function setDisplayMotivations(bool $displayMotivations): self
    {
        $this->displayMotivations = $displayMotivations;

        return $this;
    }

    public function getDisplayCaracSportives(): ?bool
    {
        return $this->displayCaracSportives;
    }

    public function setDisplayCaracSportives(bool $displayCaracSportives): self
    {
        $this->displayCaracSportives = $displayCaracSportives;

        return $this;
    }

    public function getDisplayDispo(): ?bool
    {
        return $this->displayDispo;
    }

    public function setDisplayDispo(bool $displayDispo): self
    {
        $this->displayDispo = $displayDispo;

        return $this;
    }

    public function getDisplayLevel(): ?bool
    {
        return $this->displayLevel;
    }

    public function setDisplayLevel(bool $displayLevel): self
    {
        $this->displayLevel = $displayLevel;

        return $this;
    }

    public function getNotifMatch(): ?bool
    {
        return $this->notifMatch;
    }

    public function setNotifMatch(bool $notifMatch): self
    {
        $this->notifMatch = $notifMatch;

        return $this;
    }

    public function getNotifMessage(): ?bool
    {
        return $this->notifMessage;
    }

    public function setNotifMessage(bool $notifMessage): self
    {
        $this->notifMessage = $notifMessage;

        return $this;
    }

    public function getNotifMaj(): ?bool
    {
        return $this->notifMaj;
    }

    public function setNotifMaj(bool $notifMaj): self
    {
        $this->notifMaj = $notifMaj;

        return $this;
    }

    public function getMatchPush(): ?bool
    {
        return $this->MatchPush;
    }

    public function setMatchPush(bool $MatchPush): self
    {
        $this->MatchPush = $MatchPush;

        return $this;
    }

    public function getMsgPush(): ?bool
    {
        return $this->MsgPush;
    }

    public function setMsgPush(bool $MsgPush): self
    {
        $this->MsgPush = $MsgPush;

        return $this;
    }
}
