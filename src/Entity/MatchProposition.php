<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MatchPropositionRepository")
 */
class MatchProposition
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="matchPropositions")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="matchProposedTo")
     * @ORM\JoinColumn(name="user_wanted_id", referencedColumnName="id", nullable=false)
     */
    private $userWanted;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUserWanted(): ?User
    {
        return $this->userWanted;
    }

    public function setUserWanted(?User $userWanted): self
    {
        $this->userWanted = $userWanted;

        return $this;
    }
}
