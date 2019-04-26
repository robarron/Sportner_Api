<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;


class UserController extends FOSRestController
{
//    /**
//     * @Route("/user", name="user")
//     */
//    public function index()
//    {
//        return $this->render('user/index.html.twig', [
//            'controller_name' => 'UserController',
//        ]);
//    }

    /**
     * Creates a User resource
     * @Rest\Post("/users")
     * @param Request $request
     * @return View
     */
    public function postUser(Request $request): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setEmail($request->get('email'));
        $user->setAge($request->get('age'));
        $user->setPassword($request->get('password'));
//        $user->setRoles($request->get('roles'));
        $entityManager->persist($user);
        $entityManager->flush();

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($user, Response::HTTP_CREATED);
    }

    /**
     * Retrieves an User resource by his id
     * @Rest\Get("/userById/{userId}", requirements={"id"="\d+"})
     */
    public function getUserById(int $userId): View
    {

        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findBy(['id' => $userId]);

        if (!$user) {
            throw new EntityNotFoundException('User with id '.$userId.' does not exist!');
        }

        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($user, Response::HTTP_OK);
    }

    /**
     * Retrieves an User resource By his email
     * @Rest\Get("/userByEmail/{email}")
     */
    public function getUserByEmail(string $email): View
    {

        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findBy(['email' => $email]);

        if (!$user) {
            throw new EntityNotFoundException('User with id '.$email.' does not exist!');
        }

        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($user, Response::HTTP_OK);
    }

    /**
     * Retrieves a collection of Article resource
     * @Rest\Get("/users")
     */
    public function getUsers(): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $users = $entityManager->getRepository(User::class)->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of article object
        return View::create($users, Response::HTTP_OK);
    }

    /**
     * Retrieves a collection of Users resource
     * @Rest\Get("/users_without_me/{userId}")
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
    public function getUsersWithoutCurrentUser(string $userId, ParamFetcherInterface $paramFetcher, Request $request): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $users = $entityManager->getRepository(User::class)->FindAllUsersExceptMe($userId);

        $adapter = new ArrayAdapter($users);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(1);
        $pagerfanta->setCurrentPage($paramFetcher->get('page'));

        $formatted = [];

        foreach ($pagerfanta as $param) {
            $formatted = [
                'id' => $param->getId() ?: null,
                'email' => $param->getEmail() ?: null,
                'images' => $param->getImages() ?: null,
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
