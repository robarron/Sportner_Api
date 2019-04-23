<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\User;
use App\Service\ImageService;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface as Serializer;

class ImageController extends AbstractController
{

    /**
     * Creates an Image resource
     * @Rest\Post("/image")
     * @param Request $request
     * @param Serializer $serializer
     * @return View
     */
    public function postImage(Request $request, Serializer $serializer): View
    {

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(["email" => "rbarron@carvivo.com"]);

        $imageArray = $request->files->get('photo');

        $image = new Image();
        $image->setImage($imageArray);
        $image->setImageFile($imageArray);
        $image->setUser($user);
        $serializer->serialize($image, 'json');


        $entityManager->persist($image);
        $image->setImagePath($image->getRelativeImageDir());
        $entityManager->flush();

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($image, Response::HTTP_CREATED);
    }
}
