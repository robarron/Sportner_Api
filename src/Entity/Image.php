<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
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
        return __DIR__ . '/../../public/upload/img';
    }

    public function getRelativeImageDir() {
            // the relative directory path where uploaded documents should be saved
            return 'public/upload/img' . $this->getUser()->getId()."/";
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


}