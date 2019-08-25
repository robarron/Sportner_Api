<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserLikeCommentRepository")
 */
class UserLikeComment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userLikeComments")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FeedComment", inversedBy="userLikeComments")
     */
    private $feedComment;

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

    public function getFeedComment(): ?FeedComment
    {
        return $this->feedComment;
    }

    public function setFeedComment(?FeedComment $feedComment): self
    {
        $this->feedComment = $feedComment;

        return $this;
    }
}
