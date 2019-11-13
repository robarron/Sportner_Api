<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FeedCommentRepository")
 */
class FeedComment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Feed", inversedBy="feedComments")
     */
    private $feed;

    /**
     * @ORM\Column(type="string", length=400)
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="feedComments")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserLikeComment", mappedBy="feedComment")
     */
    private $userLikeComments;

    public function __construct()
    {
        $this->userLikeComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFeed(): ?Feed
    {
        return $this->feed;
    }

    public function setFeed(?Feed $feed): self
    {
        $this->feed = $feed;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
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

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * @return Collection|UserLikeComment[]
     */
    public function getUserLikeComments(): Collection
    {
        return $this->userLikeComments;
    }

    public function addUserLikeComment(UserLikeComment $userLikeComment): self
    {
        if (!$this->userLikeComments->contains($userLikeComment)) {
            $this->userLikeComments[] = $userLikeComment;
            $userLikeComment->setFeedComment($this);
        }

        return $this;
    }

    public function removeUserLikeComment(UserLikeComment $userLikeComment): self
    {
        if ($this->userLikeComments->contains($userLikeComment)) {
            $this->userLikeComments->removeElement($userLikeComment);
            // set the owning side to null (unless already changed)
            if ($userLikeComment->getFeedComment() === $this) {
                $userLikeComment->setFeedComment(null);
            }
        }

        return $this;
    }
}
