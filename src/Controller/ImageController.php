<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\User;
use App\Service\ImageService;
use DateTime;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
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

        $photoParam = $request->files->get('photo');
        $userEmail = $request->get('userEmail');
        $isProfilImage = $request->get('profilImage');
        $base64 = $request->get('base64');

        $user = $entityManager->getRepository(User::class)->findOneBy(["email" => $userEmail]);

        $image = new Image();
        $image->setImage($photoParam);
        $image->setImageFile($photoParam);
        $image->setProfilImage($isProfilImage);
        $image->setUser($user);
        $image->setCreatedAt(new DateTime(date('Y-m-d h:m')));
        $image->setUpdatedAt(new DateTime(date('Y-m-d h:m')));
        $image->setImagePath('string');
        $image->setImagePathForRequire('string');

        $serializer->serialize($image, 'json');
        $image->setBase64($base64);


        $entityManager->persist($image);
        $entityManager->flush();

        $image->setImagePath($image->getRelativeImageDir());
        $image->setImagePathForRequire($image->getRelativeImageDirForRequire());

        $entityManager->persist($image);
        $entityManager->flush();
        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($image, Response::HTTP_CREATED);
    }

    /**
     * Retrieves a collection of Images resource
     * @Rest\Get("/images_without_me/{userId}")
     * @REST\QueryParam(
     *     name="page",
     *     requirements="\d+",
     *     default="1",
     *     description="The pagination offset. (e.g. : ?page=2)"
     * )
     * @param string $userId
     * @param ParamFetcherInterface $paramFetcher
     * @param Request $request
     * @return View
     */
    public function getImagesWithoutCurrentUser(string $userId, ParamFetcherInterface $paramFetcher, Request $request): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $images = $entityManager->getRepository(Image::class)->FindAllImagesExceptMe($userId);

        $adapter = new ArrayAdapter($images);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(1);
        $pagerfanta->setCurrentPage($paramFetcher->get('page'));

        $formatted = [];

        foreach ($pagerfanta as $param) {
            $formatted = [
                'id' => $param->getId() ?: null,
                'image_path' => $param->getImagePath() ?: null,
                'created_at' => $param->getCreatedAt() ?: null,
                'profil_image' => $param->getProfilImage() ?: null,
                'path_for_require' => $param->getImagePathForRequire() ?: null,
                'base64' => $param->getBase64() ?: null,
                'user' => $param->getUser() ?: null,
            ];
        }

        $pagerInfo[] = [
            'Limit' => $pagerfanta->getMaxPerPage(),
            'Current page' => $pagerfanta->getCurrentPage(),
            'Total items' => $pagerfanta->getNbResults(),
            'Total pages' => $pagerfanta->getNbPages(),
            'Current page results'  => count($pagerfanta->getCurrentPageResults()),
        ];

        $formatted = array_merge($pagerInfo, $formatted);

        return $this->createFosRestView($formatted);
    }

    /**
     * @param array $data
     * @param int $statusCode
     * @param array $headers
     * @param string $format
     *
     * @return View
     */
    public function createFosRestView(array $data, $statusCode = Response::HTTP_OK, array $headers = [], $format = 'json')
    {
        $finalData = ['result' => $data];
        $view = View::create($finalData, $statusCode, $headers);
        $view->setFormat($format);

        return $view;
    }
}
