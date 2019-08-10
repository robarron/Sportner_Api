<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GenderSearchRepository")
 */
class GenderSearch
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserParameters", mappedBy="genderSearch")
     */
    private $UserParameters;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function __construct()
    {
        $this->UserParameters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|UserParameters[]
     */
    public function getUserParameters(): Collection
    {
        return $this->UserParameters;
    }

    public function addUserParameter(UserParameters $userParameter): self
    {
        if (!$this->UserParameters->contains($userParameter)) {
            $this->UserParameters[] = $userParameter;
            $userParameter->setGenderSearch($this);
        }

        return $this;
    }

    public function removeUserParameter(UserParameters $userParameter): self
    {
        if ($this->UserParameters->contains($userParameter)) {
            $this->UserParameters->removeElement($userParameter);
            // set the owning side to null (unless already changed)
            if ($userParameter->getGenderSearch() === $this) {
                $userParameter->setGenderSearch(null);
            }
        }

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

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
}
