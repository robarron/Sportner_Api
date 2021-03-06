<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", mappedBy="user")
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $facebookId;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $createdFromFacebook;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $passwordPlainText;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $birthdayDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, name="favorite_sport")
     */
    private $favoriteSport;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="string", length=400, nullable=true)
     */
    private $motivation;

    /**
     * @ORM\Column(type="string", length=400, nullable=true)
     */
    private $sportCaractertics;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $level;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $mondayBeginningHour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $mondayFinishHour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $tuedsayBeginningHour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $tuesdayFinishHour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $wednesdayBeginningHour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $wednesdayFinishHour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $thursdayBeginningHour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $thursdayFinishHour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $fridayBeginningHour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $fridayFinishHour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $saturdayBeginningHour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $saturdayFinishHour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $sundayBeginningHour;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $sundayFinishHour;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $challengePoint;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SponsorshipCode", mappedBy="partnerShip")
     */
    private $partnerShipCodes;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastDailyPointsDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserMatch", mappedBy="user", orphanRemoval=true)
     */
    private $matches;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserMatch", mappedBy="secondUser", orphanRemoval=true)
     */
    private $secondUserMatches;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MatchProposition", mappedBy="user", orphanRemoval=true)
     */
    private $matchPropositions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MatchProposition", mappedBy="userWanted", orphanRemoval=true)
     */
    private $matchProposedTo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\SponsorshipCode", cascade={"persist", "remove"})
     */
    private $sponsorshipCode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="sender")
     */
    private $messagesSender;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Message", mappedBy="receptor")
     */
    private $messagesReceptor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Feed", mappedBy="user")
     */
    private $feeds;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FeedComment", mappedBy="user")
     */
    private $feedComments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserLikeComment", mappedBy="user")
     */
    private $userLikeComments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserLikeFeed", mappedBy="user")
     */
    private $userLikeFeeds;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->matches = new ArrayCollection();
        $this->secondUserMatches = new ArrayCollection();
        $this->matchPropositions = new ArrayCollection();
        $this->matchProposedTo = new ArrayCollection();
        $this->partnerShipCodes = new ArrayCollection();
        $this->messagesSender = new ArrayCollection();
        $this->messagesReceptor = new ArrayCollection();
        $this->feeds = new ArrayCollection();
        $this->feedComments = new ArrayCollection();
        $this->userLikeComments = new ArrayCollection();
        $this->userLikeFeeds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getUser() === $this) {
                $image->setUser(null);
            }
        }

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFacebookId(): ?int
    {
        return $this->facebookId;
    }

    public function setFacebookId(?int $facebookId): self
    {
        $this->facebookId = $facebookId;

        return $this;
    }

    public function getCreatedFromFacebook(): ?bool
    {
        return $this->createdFromFacebook;
    }

    public function setCreatedFromFacebook(?bool $createdFromFacebook): self
    {
        $this->createdFromFacebook = $createdFromFacebook;

        return $this;
    }

    public function getPasswordPlainText(): ?string
    {
        return $this->passwordPlainText;
    }

    public function setPasswordPlainText(string $passwordPlainText): self
    {
        $this->passwordPlainText = $passwordPlainText;

        return $this;
    }

    public function getBirthdayDate(): ?\DateTimeInterface
    {
        return $this->birthdayDate;
    }

    public function setBirthdayDate(?\DateTimeInterface $birthdayDate): self
    {
        $this->birthdayDate = $birthdayDate;

        return $this;
    }

    public function getFavoriteSport(): ?string
    {
        return $this->favoriteSport;
    }

    public function setFavoriteSport(?string $favoriteSport): self
    {
        $this->favoriteSport = $favoriteSport;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(?float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param mixed $images
     */
    public function setImages($images): void
    {
        $this->images = $images;
    }

    public function getMotivation(): ?string
    {
        return $this->motivation;
    }

    public function setMotivation(?string $motivation): self
    {
        $this->motivation = $motivation;

        return $this;
    }

    public function getSportCaractertics(): ?string
    {
        return $this->sportCaractertics;
    }

    public function setSportCaractertics(?string $sportCaractertics): self
    {
        $this->sportCaractertics = $sportCaractertics;

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

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(?string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getMondayBeginningHour(): ?\DateTimeInterface
    {
        return $this->mondayBeginningHour;
    }

    public function setMondayBeginningHour(?\DateTimeInterface $mondayBeginningHour): self
    {
        $this->mondayBeginningHour = $mondayBeginningHour;

        return $this;
    }

    public function getMondayFinishHour(): ?\DateTimeInterface
    {
        return $this->mondayFinishHour;
    }

    public function setMondayFinishHour(?\DateTimeInterface $mondayFinishHour): self
    {
        $this->mondayFinishHour = $mondayFinishHour;

        return $this;
    }

    public function getTuedsayBeginningHour(): ?\DateTimeInterface
    {
        return $this->tuedsayBeginningHour;
    }

    public function setTuedsayBeginningHour(?\DateTimeInterface $tuedsayBeginningHour): self
    {
        $this->tuedsayBeginningHour = $tuedsayBeginningHour;

        return $this;
    }

    public function getTuesdayFinishHour(): ?\DateTimeInterface
    {
        return $this->tuesdayFinishHour;
    }

    public function setTuesdayFinishHour(?\DateTimeInterface $tuesdayFinishHour): self
    {
        $this->tuesdayFinishHour = $tuesdayFinishHour;

        return $this;
    }

    public function getWednesdayBeginningHour(): ?\DateTimeInterface
    {
        return $this->wednesdayBeginningHour;
    }

    public function setWednesdayBeginningHour(?\DateTimeInterface $wednesdayBeginningHour): self
    {
        $this->wednesdayBeginningHour = $wednesdayBeginningHour;

        return $this;
    }

    public function getWednesdayFinishHour(): ?\DateTimeInterface
    {
        return $this->wednesdayFinishHour;
    }

    public function setWednesdayFinishHour(?\DateTimeInterface $wednesdayFinishHour): self
    {
        $this->wednesdayFinishHour = $wednesdayFinishHour;

        return $this;
    }

    public function getThursdayBeginningHour(): ?\DateTimeInterface
    {
        return $this->thursdayBeginningHour;
    }

    public function setThursdayBeginningHour(?\DateTimeInterface $thursdayBeginningHour): self
    {
        $this->thursdayBeginningHour = $thursdayBeginningHour;

        return $this;
    }

    public function getThursdayFinishHour(): ?\DateTimeInterface
    {
        return $this->thursdayFinishHour;
    }

    public function setThursdayFinishHour(?\DateTimeInterface $thursdayFinishHour): self
    {
        $this->thursdayFinishHour = $thursdayFinishHour;

        return $this;
    }

    public function getFridayBeginningHour(): ?\DateTimeInterface
    {
        return $this->fridayBeginningHour;
    }

    public function setFridayBeginningHour(?\DateTimeInterface $fridayBeginningHour): self
    {
        $this->fridayBeginningHour = $fridayBeginningHour;

        return $this;
    }

    public function getFridayFinishHour(): ?\DateTimeInterface
    {
        return $this->fridayFinishHour;
    }

    public function setFridayFinishHour(?\DateTimeInterface $fridayFinishHour): self
    {
        $this->fridayFinishHour = $fridayFinishHour;

        return $this;
    }

    public function getSaturdayBeginningHour(): ?\DateTimeInterface
    {
        return $this->saturdayBeginningHour;
    }

    public function setSaturdayBeginningHour(?\DateTimeInterface $saturdayBeginningHour): self
    {
        $this->saturdayBeginningHour = $saturdayBeginningHour;

        return $this;
    }

    public function getSaturdayFinishHour(): ?\DateTimeInterface
    {
        return $this->saturdayFinishHour;
    }

    public function setSaturdayFinishHour(?\DateTimeInterface $saturdayFinishHour): self
    {
        $this->saturdayFinishHour = $saturdayFinishHour;

        return $this;
    }

    public function getSundayBeginningHour(): ?\DateTimeInterface
    {
        return $this->sundayBeginningHour;
    }

    public function setSundayBeginningHour(?\DateTimeInterface $sundayBeginningHour): self
    {
        $this->sundayBeginningHour = $sundayBeginningHour;

        return $this;
    }

    public function getSundayFinishHour(): ?\DateTimeInterface
    {
        return $this->sundayFinishHour;
    }

    public function setSundayFinishHour(?\DateTimeInterface $sundayFinishHour): self
    {
        $this->sundayFinishHour = $sundayFinishHour;

        return $this;
    }

    public function getChallengePoint(): ?int
    {
        return $this->challengePoint;
    }

    public function setChallengePoint(?int $challengePoint): self
    {
        $this->challengePoint = $challengePoint;

        return $this;
    }

    public function getLastDailyPointsDate(): ?\DateTimeInterface
    {
        return $this->lastDailyPointsDate;
    }

    public function setLastDailyPointsDate(?\DateTimeInterface $lastDailyPointsDate): self
    {
        $this->lastDailyPointsDate = $lastDailyPointsDate;

        return $this;
    }

    /**
     * @return Collection|UserMatch[]
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }

    /**
     * @return mixed
     */
    public function getSecondUserMatches()
    {
        return $this->secondUserMatches;
    }

    /**
     * @param mixed $secondUserMatches
     */
    public function setSecondUserMatches($secondUserMatches): void
    {
        $this->secondUserMatches = $secondUserMatches;
    }

    /**
     * @return Collection|MatchProposition[]
     */
    public function getMatchPropositions(): Collection
    {
        return $this->matchPropositions;
    }

    public function addMatchProposition(MatchProposition $matchProposition): self
    {
        if (!$this->matchPropositions->contains($matchProposition)) {
            $this->matchPropositions[] = $matchProposition;
            $matchProposition->setUser($this);
        }

        return $this;
    }

    public function removeMatchProposition(MatchProposition $matchProposition): self
    {
        if ($this->matchPropositions->contains($matchProposition)) {
            $this->matchPropositions->removeElement($matchProposition);
            // set the owning side to null (unless already changed)
            if ($matchProposition->getUser() === $this) {
                $matchProposition->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MatchProposition[]
     */
    public function getMatchProposedTo(): Collection
    {
        return $this->matchProposedTo;
    }

    public function addMatchProposedTo(MatchProposition $matchProposedTo): self
    {
        if (!$this->matchProposedTo->contains($matchProposedTo)) {
            $this->matchProposedTo[] = $matchProposedTo;
            $matchProposedTo->setUserWanted($this);
        }

        return $this;
    }

    public function removeMatchProposedTo(MatchProposition $matchProposedTo): self
    {
        if ($this->matchProposedTo->contains($matchProposedTo)) {
            $this->matchProposedTo->removeElement($matchProposedTo);
            // set the owning side to null (unless already changed)
            if ($matchProposedTo->getUserWanted() === $this) {
                $matchProposedTo->setUserWanted(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SponsorshipCode[]
     */
    public function getPartnerShipCodes(): Collection
    {
        return $this->partnerShipCodes;
    }

    public function addPartnerShipCode(SponsorshipCode $partnerShipCode): self
    {
        if (!$this->partnerShipCodes->contains($partnerShipCode)) {
            $this->partnerShipCodes[] = $partnerShipCode;
            $partnerShipCode->setPartnerShip($this);
        }

        return $this;
    }

    public function removePartnerShipCode(SponsorshipCode $partnerShipCode): self
    {
        if ($this->partnerShipCodes->contains($partnerShipCode)) {
            $this->partnerShipCodes->removeElement($partnerShipCode);
            // set the owning side to null (unless already changed)
            if ($partnerShipCode->getPartnerShip() === $this) {
                $partnerShipCode->setPartnerShip(null);
            }
        }

        return $this;
    }

    public function getSponsorshipCode(): ?SponsorshipCode
    {
        return $this->sponsorshipCode;
    }

    public function setSponsorshipCode(?SponsorshipCode $sponsorshipCode): self
    {
        $this->sponsorshipCode = $sponsorshipCode;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessagesSender(): Collection
    {
        return $this->messagesSender;
    }

    public function addMessagesSender(Message $messagesSender): self
    {
        if (!$this->messagesSender->contains($messagesSender)) {
            $this->messagesSender[] = $messagesSender;
            $messagesSender->setSender($this);
        }

        return $this;
    }

    public function removeMessagesSender(Message $messagesSender): self
    {
        if ($this->messagesSender->contains($messagesSender)) {
            $this->messagesSender->removeElement($messagesSender);
            // set the owning side to null (unless already changed)
            if ($messagesSender->getSender() === $this) {
                $messagesSender->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessagesReceptor(): Collection
    {
        return $this->messagesReceptor;
    }

    public function addMessagesReceptor(Message $messagesReceptor): self
    {
        if (!$this->messagesReceptor->contains($messagesReceptor)) {
            $this->messagesReceptor[] = $messagesReceptor;
            $messagesReceptor->setReceptor($this);
        }

        return $this;
    }

    public function removeMessagesReceptor(Message $messagesReceptor): self
    {
        if ($this->messagesReceptor->contains($messagesReceptor)) {
            $this->messagesReceptor->removeElement($messagesReceptor);
            // set the owning side to null (unless already changed)
            if ($messagesReceptor->getReceptor() === $this) {
                $messagesReceptor->setReceptor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Feed[]
     */
    public function getFeeds(): Collection
    {
        return $this->feeds;
    }

    public function addFeed(Feed $feed): self
    {
        if (!$this->feeds->contains($feed)) {
            $this->feeds[] = $feed;
            $feed->setUser($this);
        }

        return $this;
    }

    public function removeFeed(Feed $feed): self
    {
        if ($this->feeds->contains($feed)) {
            $this->feeds->removeElement($feed);
            // set the owning side to null (unless already changed)
            if ($feed->getUser() === $this) {
                $feed->setUser(null);
            }
        }

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
            $feedComment->setUser($this);
        }

        return $this;
    }

    public function removeFeedComment(FeedComment $feedComment): self
    {
        if ($this->feedComments->contains($feedComment)) {
            $this->feedComments->removeElement($feedComment);
            // set the owning side to null (unless already changed)
            if ($feedComment->getUser() === $this) {
                $feedComment->setUser(null);
            }
        }

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
            $userLikeComment->setUser($this);
        }

        return $this;
    }

    public function removeUserLikeComment(UserLikeComment $userLikeComment): self
    {
        if ($this->userLikeComments->contains($userLikeComment)) {
            $this->userLikeComments->removeElement($userLikeComment);
            // set the owning side to null (unless already changed)
            if ($userLikeComment->getUser() === $this) {
                $userLikeComment->setUser(null);
            }
        }

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
            $userLikeFeed->setUser($this);
        }

        return $this;
    }

    public function removeUserLikeFeed(UserLikeFeed $userLikeFeed): self
    {
        if ($this->userLikeFeeds->contains($userLikeFeed)) {
            $this->userLikeFeeds->removeElement($userLikeFeed);
            // set the owning side to null (unless already changed)
            if ($userLikeFeed->getUser() === $this) {
                $userLikeFeed->setUser(null);
            }
        }

        return $this;
    }


}
