<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Time;


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
     * @Rest\Get("/userByEmail/{email}", name= "api_user_one" )
     */
    public function getUserByEmail(string $email): View
    {

        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

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

        return $this->get('api_service')->createFosRestView($formatted);
    }

    /**
     * update an image ressource
     * @Rest\View()
     * @Rest\Patch("/users/{userId}")
     * @param Request $request
     * @param int $userId
     * @return View
     */
    public function modifyUserInfos(Request $request, int $userId): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager
            ->getRepository(User::class)
            ->findOneBy(["id" => $userId]);

        if (empty($user)) {
            return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        $tmp = $request->get('mondayDispoBeginning');
        $ooo = strtotime($tmp);
//        dump(strtotime("2:57"));die;
$coucou = new \DateTime($request->get('mondayDispoBeginning'));
//        dump($coucou->format('h:i'));die;

        $request->get('motivation') && $request->get('motivation') != $user->getMotivation() ? $user->setMotivation($request->get('motivation')) : null;
        $request->get('userSportCarac') && $request->get('userSportCarac') != $user->getSportCaractertics() ? $user->setSportCaractertics($request->get('userSportCarac')) : null;
        $request->get('sexe') && $request->get('sexe') != $user->getSexe() ? $user->setSexe($request->get('sexe')) : null;
        $request->get('city') && $request->get('city') != $user->getCity() ? $user->setCity($request->get('city')) : null;
        $request->get('favoriteSport') && $request->get('favoriteSport') != $user->getFavoriteSport() ? $user->setFavoriteSport($request->get('favoriteSport')) : null;
        $request->get('level') && $request->get('level') != $user->getLevel() ? $user->setLevel($request->get('level')) : null;
        $request->get('mondayDispoBeginning') && $request->get('mondayDispoBeginning') != $user->getMondayBeginningHour() ? $user->setMondayBeginningHour(new \DateTime($request->get('mondayDispoBeginning'))) : null;
        $request->get('mondayDispoClosing') && $request->get('mondayDispoClosing') != $user->getMondayFinishHour() ? $user->setMondayFinishHour(new \DateTime(('mondayDispoClosing'))) : null;
        $request->get('tuesdayDispoBeginning') && $request->get('tuesdayDispoBeginning') != $user->getTuedsayBeginningHour() ? $user->setTuesdayFinishHour(new \DateTime($request->get('tuesdayDispoBeginning'))) : null;
        $request->get('tuesdayDispoClosing') && $request->get('tuesdayDispoClosing') != $user->getTuesdayFinishHour() ? $user->setTuesdayFinishHour(new \DateTime($request->get('tuesdayDispoClosing'))) : null;
        $request->get('wednesdayDispoBeginning') && $request->get('wednesdayDispoBeginning') != $user->getWednesdayBeginningHour() ? $user->setWednesdayBeginningHour(new \DateTime($request->get('wednesdayDispoBeginning'))) : null;
        $request->get('wednesdayDispoClosing') && $request->get('wednesdayDispoClosing') != $user->getWednesdayFinishHour() ? $user->setWednesdayFinishHour(new \DateTime($request->get('wednesdayDispoClosing'))) : null;
        $request->get('thursdayDispoBeginning') && $request->get('thursdayDispoBeginning') != $user->getThursdayBeginningHour() ? $user->setThursdayBeginningHour(new \DateTime($request->get('thursdayDispoBeginning'))) : null;
        $request->get('thursdayDispoClosing') && $request->get('thursdayDispoClosing') != $user->getThursdayFinishHour() ? $user->setThursdayFinishHour(new \DateTime($request->get('thursdayDispoClosing'))) : null;
        $request->get('fridayDispoBeginning') && $request->get('fridayDispoBeginning') != $user->getFridayBeginningHour() ? $user->setFridayBeginningHour(new \DateTime($request->get('fridayDispoBeginning'))) : null;
        $request->get('fridayDispoClosing') && $request->get('fridayDispoClosing') != $user->getFridayFinishHour() ? $user->setFridayFinishHour(new \DateTime($request->get('fridayDispoClosing'))) : null;
        $request->get('saturdayDispoBeginning') && $request->get('saturdayDispoBeginning') != $user->getSaturdayBeginningHour() ? $user->setSaturdayBeginningHour(new \DateTime($request->get('saturdayDispoBeginning'))) : null;
        $request->get('saturdayDispoClosing') && $request->get('saturdayDispoClosing') != $user->getSaturdayFinishHour() ? $user->setSaturdayFinishHour(new \DateTime($request->get('saturdayDispoClosing'))) : null;
        $request->get('sundayDispoBeginning') && $request->get('sundayDispoBeginning') != $user->getSundayBeginningHour() ? $user->setSundayBeginningHour(new \DateTime($request->get('sundayDispoBeginning'))) : null;
        $request->get('sundayDispoClosing') && $request->get('sundayDispoClosing') != $user->getSundayFinishHour() ? $user->setSundayFinishHour(new \DateTime($request->get('sundayDispoClosing'))) : null;

        $entityManager->persist($user);
        $entityManager->flush();

        return View::create($user, Response::HTTP_OK);
    }

}
