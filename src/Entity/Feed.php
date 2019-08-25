<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FeedRepository")
 */
class Feed
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="feeds")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=400)
     */
    private $content;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FeedComment", mappedBy="feed")
     */
    private $feedComments;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserLikeFeed", mappedBy="feed")
     */
    private $userLikeFeeds;

    public function __construct()
    {
        $this->feedComments = new ArrayCollection();
        $this->userLikeFeeds = new ArrayCollection();
    }

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(?int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * @return Collection|FeedComment[]
     */
    public function getFeedComments(): Collection
    {
        return $this->feedComments;
    }

    public function addFeedComment(FeedComment $feedComment): self
    {
        if (!$this->feedComments->contains($feedComment)) {
            $this->feedComments[] = $feedComment;
            $feedComment->setFeed($this);
        }

        return $this;
    }

    public function removeFeedComment(FeedComment $feedComment): self
    {
        if ($this->feedComments->contains($feedComment)) {
            $this->feedComments->removeElement($feedComment);
            // set the owning side to null (unless already changed)
            if ($feedComment->getFeed() === $this) {
                $feedComment->setFeed(null);
            }
        }

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

    /**
     * @return Collection|UserLikeFeed[]
     */
    public function getUserLikeFeeds(): Collection
    {
        return $this->userLikeFeeds;
    }

    public function addUserLikeFeed(UserLikeFeed $userLikeFeed): self
    {
        if (!$this->userLikeFeeds->contains($userLikeFeed)) {
            $this->userLikeFeeds[] = $userLikeFeed;
            $userLikeFeed->setFeed($this);
        }

        return $this;
    }

    public function removeUserLikeFeed(UserLikeFeed $userLikeFeed): self
    {
        if ($this->userLikeFeeds->contains($userLikeFeed)) {
            $this->userLikeFeeds->removeElement($userLikeFeed);
            // set the owning side to null (unless already changed)
            if ($userLikeFeed->getFeed() === $this) {
                $userLikeFeed->setFeed(null);
            }
        }

        return $this;
    }
}
