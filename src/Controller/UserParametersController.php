<?php

namespace App\Controller;

use App\Entity\GenderSearch;
use App\Entity\User;
use App\Entity\UserParameters;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;


class UserParametersController extends AbstractController
{
    /**
     * @Route("/user/parameters", name="user_parameters")
     */
    public function index()
    {
        return $this->render('user_parameters/index.html.twig', [
            'controller_name' => 'UserParametersController',
        ]);
    }

    /**
     * Creates a UserParameter resource
     * @Rest\Post("/userParameter/{userId}")
     * @param Request $request
     * @param int $userId
     * @return View
     */
    public function postUser(Request $request, int $userId): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);
        $gender = $entityManager->getRepository(GenderSearch::class)->findOneBy(['value' => $request->get('sexe')]);

        if ($request->get('userPhone') && $request->get('userPhone') !== $user->getPhoneNumber())
        {
            $user->setPhoneNumber($request->get('userPhone'));
        } elseif ($request->get('userMail') && $request->get('userMail') !== $user->getEmail())
        {
            $user->setEmail($request->get('userMail'));
        }

        $userParameter = new UserParameters();
        $userParameter->setLocalisation($request->get('userPlacement'));
        $userParameter->setMaxDistance($request->get('distance'));
        $userParameter->setGenderSearch($gender);
        $userParameter->setMinAgeSearch($request->get('minAge'));
        $userParameter->setMaxAgeSearch($request->get('maxAge'));
        $userParameter->setDisplayProfil($request->get('displayProfil'));
        $userParameter->setDisplayPic($request->get('displayPic'));
        $userParameter->setDisplayMotivations($request->get('displayMotivations'));
        $userParameter->setDisplayCaracSportives($request->get('displayCaracSportives'));
        $userParameter->setDisplayDispo($request->get('displayDispo'));
        $userParameter->setDisplayLevel($request->get('displayLevel'));
        $userParameter->setNotifMatch($request->get('matchNotif'));
        $userParameter->setNotifMessage($request->get('msgNotif'));
        $userParameter->setNotifMaj($request->get('majNotif'));
        $userParameter->setMatchPush($request->get('matchPush'));
        $userParameter->setMsgPush($request->get('msgPush'));
        $userParameter->setUser($user);

        $entityManager->persist($userParameter);
        $entityManager->flush();

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($userParameter, Response::HTTP_CREATED);
    }

    /**
     * Update a UserParameter resource
     * @Rest\Patch("/userParameter/{userId}")
     * @param Request $request
     * @param int $userId
     * @return View
     */
    public function patchUser(Request $request, int $userId): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);
        $gender = $entityManager->getRepository(GenderSearch::class)->findOneBy(['value' => $request->get('sexe')]);

        $userParameter = $entityManager
            ->getRepository(UserParameters::class)
            ->findOneBy(["user" => $userId]);

        if (empty($userParameter)) {
            return View::create(['message' => "parameters for user " + $userId +  "not found"], Response::HTTP_NOT_FOUND);
        }

        $request->get('userPhone') != $user->getPhoneNumber() ? $user->setPhoneNumber($request->get('userPhone')) : null;
        $request->get('userMail') != $user->getEmail() ? $user->setEmail($request->get('userMail')) : null;

        $request->get('userPlacement') != $userParameter->getLocalisation() ? $userParameter->setLocalisation($request->get('userPlacement')) : null;
        $request->get('distance') != $userParameter->getMaxDistance() ? $userParameter->setMaxDistance($request->get('distance')) : null;
        $gender !== $userParameter->getGenderSearch() ? $userParameter->setGenderSearch($gender) : null;
        $request->get('minAge') != $userParameter->getMinAgeSearch() ? $userParameter->setMinAgeSearch($request->get('minAge')) : null;
        $request->get('maxAge') != $userParameter->getMaxAgeSearch() ? $userParameter->setMaxAgeSearch($request->get('maxAge')) : null;
        $request->get('displayProfil') != $userParameter->getDisplayProfil() ? $userParameter->setDisplayProfil($request->get('displayProfil')) : null;
        $request->get('displayPic') != $userParameter->getDisplayPic() ? $userParameter->setDisplayPic($request->get('displayPic')) : null;
        $request->get('displayMotivations') != $userParameter->getDisplayMotivations() ? $userParameter->setDisplayMotivations($request->get('displayMotivations')) : null;
        $request->get('displayCaracSportives') != $userParameter->getDisplayCaracSportives() ? $userParameter->setDisplayCaracSportives($request->get('displayCaracSportives')) : null;
        $request->get('displayDispo') != $userParameter->getDisplayDispo() ? $userParameter->setDisplayDispo($request->get('displayDispo')) : null;
        $request->get('displayLevel') != $userParameter->getDisplayLevel() ? $userParameter->setDisplayLevel($request->get('displayLevel')) : null;
        $request->get('matchNotif') != $userParameter->getNotifMatch() ? $userParameter->setNotifMatch($request->get('matchNotif')) : null;
        $request->get('msgNotif') != $userParameter->getNotifMessage() ? $userParameter->setNotifMessage($request->get('msgNotif')) : null;
        $request->get('majNotif') != $userParameter->getNotifMaj() ? $userParameter->setNotifMaj($request->get('majNotif')) : null;
        $request->get('matchPush') != $userParameter->getMatchPush() ? $userParameter->setMatchPush($request->get('matchPush')) : null;
        $request->get('msgPush') != $userParameter->getMsgPush() ? $userParameter->setMsgPush($request->get('msgPush')) : null;


        $entityManager->persist($userParameter);
        $entityManager->flush();

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($user, Response::HTTP_OK);
    }

    /**
     * Retrieves a collection of userParameter resource
     * @Rest\Get("/userParameter/{userId}")
     * @param int $userId
     * @return View
     */
    public function getUserParameters(int $userId): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);
        $userParameter = $entityManager->getRepository(UserParameters::class)->findOneBy(['user' => $user]);

        if (empty($userParameter)) {
            return View::create(['message' => 'Param for user was not found'], Response::HTTP_NOT_FOUND);
        }
        // In case our GET was a success we need to return a 200 HTTP OK response with the collection of article object
        return View::create($userParameter, Response::HTTP_OK);
    }

}
