<?php

namespace App\Service;


use App\Entity\Image;
use Stof\DoctrineExtensionsBundle\Uploadable\UploadableManager;

class ImageService
{
    public function uploadFile(UploadableManager $uploadableManager, Image $file, string $fileInfo)
    {
        $uploadableManager->markEntityToUpload($file, $fileInfo);
    }
}