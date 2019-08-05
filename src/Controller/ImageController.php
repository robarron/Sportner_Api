<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\User;
use DateTime;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface as Serializer;

class ImageController extends AbstractController
{

    /**
     * Creates an Image resource
     * @Rest\Post("/image/{userId}")
     * @param Request $request
     * @param Serializer $serializer
     * @return View
     */
    public function postImage(Request $request, Serializer $serializer, int $userId): View
    {

        $entityManager = $this->getDoctrine()->getManager();

        $profil_pic = $request->get('profil_pic');

        $user = $entityManager->getRepository(User::class)->findOneBy(["id" => $userId]);

        $image = new Image();
        $image->setUser($user);
        $image->setCreatedAt(new DateTime(date('Y-m-d h:m')));
        $image->setUpdatedAt(new DateTime(date('Y-m-d h:m')));
        $image->setImagePath('string');
        $image->setImagePathForRequire('string');

        $serializer->serialize($image, 'json');
        $profil_pic ? $image->setProfilPic($profil_pic) : null;

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
     * update an image ressource
     * @Rest\View()
     * @Rest\Patch("/images/{userId}")
     * @param Request $request
     * @param int $userId
     * @return View
     */
    public function addPicture(Request $request, int $userId): View
    {
        $entityManager = $this->getDoctrine()->getManager();
        $profil_pic = $request->get('profil_pic');
        $pic2 = $request->get('pic2');
        $pic3 = $request->get('pic3');
        $pic4 = $request->get('pic4');
        $pic5 = $request->get('pic5');
        $pic6 = $request->get('pic6');
//        dump($pic4);die;
        $image = $entityManager
            ->getRepository(Image::class)
            ->findOneBy(["user" => $userId]);

        if (empty($image)) {
            return View::create(['message' => 'Image not found'], Response::HTTP_NOT_FOUND);
        }

        $profil_pic ? $image->setProfilPic($profil_pic) : null;
        $pic2 ? $image->setPic2($pic2) : null;
        $pic3 ? $image->setPic3($pic3) : null;
        $pic4 ? $image->setPic4($pic4) : null;
        $pic5 ? $image->setPic5($pic5) : null;
        $pic6 ? $image->setPic6($pic6) : null;

        $entityManager->persist($image);
        $entityManager->flush();

        return View::create($image, Response::HTTP_OK);
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
     * @param int $userId
     * @param ParamFetcherInterface $paramFetcher
     * @return View
     */
    public function getImagesWithoutCurrentUser(int $userId, ParamFetcherInterface $paramFetcher): View
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
                'profil_pic' => $param->getProfilPic() ?: null,
                'path_for_require' => $param->getImagePathForRequire() ?: null,
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
     * Check if the current user has a profil picture
     * @Rest\Get("/has_profil_picture/{userId}")
     */
    public function HasUserProfilPicture(int $userId): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findBy(['id' => $userId]);

        if (!$user) {
            throw new EntityNotFoundException('User with id '.$userId.' does not exist!');
        }

        $profilPicture = $entityManager->getRepository(Image::class)->getUserProfilPicture($userId);

        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($profilPicture, Response::HTTP_OK);
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/images/{userId}")
     * @param Request $request
     * @param int $userId
     * @return View
     */
    public function removePlaceAction(Request $request, int $userId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $image = $entityManager->getRepository(Image::class)
            ->findOneBy(['user' => $userId]);

        $profil_pic = $request->get('profil_pic');
        $pic2 = $request->get('pic2');
        $pic3 = $request->get('pic3');
        $pic4 = $request->get('pic4');
        $pic5 = $request->get('pic5');
        $pic6 = $request->get('pic6');

        if (empty($image)) {
            return View::create(['message' => 'Image not found'], Response::HTTP_NOT_FOUND);
        }

        $profil_pic ? $image->setProfilPic(null) : null;
        $pic2 ? $image->setPic2(null) : null;
        $pic3 ? $image->setPic3(null) : null;
        $pic4 ? $image->setPic4(null) : null;
        $pic5 ? $image->setPic5(null) : null;
        $pic6 ? $image->setPic6(null) : null;

        $entityManager->persist($image);
        $entityManager->flush();

        return View::create($image, Response::HTTP_OK);
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
