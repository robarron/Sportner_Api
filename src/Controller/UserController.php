<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
}
