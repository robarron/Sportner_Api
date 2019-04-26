<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $image
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;


    /**
     * @Assert\File(
     * maxSize="1M",
     * mimeTypes={"image/png", "image/jpeg", "image/gif"}
     * )
     */
    public $imageFile;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="string", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="images")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imagePath;

    /**
     * @var datetime $createdAt
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var datetime $updatedAt
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $profilImage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $imagePathForRequire;

    /**
     * @ORM\Column(type="string", length=65535)
     */
    private $base64;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set image
     *
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }



    // Upload d'image

    public function getFullImagePath()
    {
        return null === $this->image ? null : $this->getUploadRootDir().$this->image;
    }

    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return $this->getTmpUploadRootDir(). '_' . $this->getUser()->getId()."/";
    }

    public function getTmpUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return 'C:/xampp/htdocs/projets/Sportner/Ressources/upload/img';
    }

    public function getRelativeImageDir() {
            // the relative directory path where uploaded documents should be saved
            return 'Ressources/upload/img_' . $this->getUser()->getId() ."/" . $this->getId() . '_' . $this->image;
    }

    public function getRelativeImageDirForRequire() {
        // the relative directory path where uploaded documents should be saved
        return 'require(\'../Ressources/upload/img_' . $this->getUser()->getId() ."/" . $this->getId() . '_' . $this->image . '\')';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUploadImage()
    {
        if (null !== $this->imageFile) {
            $this->image = 'image.' .$this->getImageFile()->guessClientExtension();
        }
    }


    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function uploadImage()
    {
        if (null === $this->imageFile) {
            return;
        }

        if(!is_dir($this->getUploadRootDir())){
            mkdir($this->getUploadRootDir());
        }

        $this->imageFile->move($this->getUploadRootDir(), $this->getId() . '_' . $this->image);

        unset($this->imageFile);
        $this->imageFile = null;

    }



    /**
     * @ORM\PostRemove()
     */
    public function removeImage()
    {
        unlink($this->getFullImagePath());
        rmdir($this->getUploadRootDir());
    }

    /**
     * @return UploadedFile
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param UploadedFile $imageFile
     */
    public function setImageFile($imageFile): void
    {
        $this->imageFile = $imageFile;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getProfilImage(): ?bool
    {
        return $this->profilImage;
    }

    public function setProfilImage(bool $profilImage): self
    {
        $this->profilImage = $profilImage;

        return $this;
    }

    public function getImagePathForRequire(): ?string
    {
        return $this->imagePathForRequire;
    }

    public function setImagePathForRequire(string $imagePathForRequire): self
    {
        $this->imagePathForRequire = $imagePathForRequire;

        return $this;
    }

    public function getBase64(): ?string
    {
        return $this->base64;
    }

    public function setBase64(string $base64): self
    {
        $this->base64 = $base64;

        return $this;
    }

}