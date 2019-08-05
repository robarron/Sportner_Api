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
     * @ORM\Column(type="string", length=255)
     */
    private $imagePathForRequire;

    /**
     * @ORM\Column(name="profil_pic", type="string", length=65000, nullable=true)
     */
    private $profilPic;

    /**
     * @ORM\Column(type="string", length=65535, nullable=true)
     */
    private $pic2;

    /**
     * @ORM\Column(type="string", length=65535, nullable=true)
     */
    private $pic3;

    /**
     * @ORM\Column(type="string", length=65535, nullable=true)
     */
    private $pic4;

    /**
     * @ORM\Column(type="string", length=65535, nullable=true)
     */
    private $pic5;

    /**
     * @ORM\Column(type="string", length=65535, nullable=true)
     */
    private $pic6;

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

    public function getImagePathForRequire(): ?string
    {
        return $this->imagePathForRequire;
    }

    public function setImagePathForRequire(string $imagePathForRequire): self
    {
        $this->imagePathForRequire = $imagePathForRequire;

        return $this;
    }

    public function getProfilPic(): ?string
    {
        return $this->profilPic;
    }

    public function setProfilPic(?string $profilPic): self
    {
        $this->profilPic = $profilPic;

        return $this;
    }

    public function getPic2(): ?string
    {
        return $this->pic2;
    }

    public function setPic2(?string $pic2): self
    {
        $this->pic2 = $pic2;

        return $this;
    }

    public function getPic3(): ?string
    {
        return $this->pic3;
    }

    public function setPic3(?string $pic3): self
    {
        $this->pic3 = $pic3;

        return $this;
    }

    public function getPic4(): ?string
    {
        return $this->pic4;
    }

    public function setPic4(?string $pic4): self
    {
        $this->pic4 = $pic4;

        return $this;
    }

    public function getPic5(): ?string
    {
        return $this->pic5;
    }

    public function setPic5(?string $pic5): self
    {
        $this->pic5 = $pic5;

        return $this;
    }

    public function getPic6(): ?string
    {
        return $this->pic6;
    }

    public function setPic6(?string $pic6): self
    {
        $this->pic6 = $pic6;

        return $this;
    }

}