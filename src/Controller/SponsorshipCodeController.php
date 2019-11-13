<?php

namespace App\Controller;

use App\Entity\SponsorshipCode;
use App\Form\SponsorshipCodeType;
use App\Repository\SponsorshipCodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;

class SponsorshipCodeController extends AbstractController
{
    /**
     * Creates a SponsorshipCode resource
     * @Rest\Post("/sponsorshipCode/{userId}")
     * @param Request $request
     * @param User $userId
     * @return View
     */
    public function postSponsorshipCode(Request $request, User $userId): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);

        if ($user->getSponsorshipCode()) {
            return View::create(['message' => "sponsorship for user " + $userId +  "already exist"], Response::HTTP_NOT_FOUND);
        }

        $sponsorshipCode = new SponsorshipCode();
        $sponsorshipCode->setSponsorshipCode($request->get('sponsorshipCode'));
        $sponsorshipCode->setSponsorshipchecked(false);
        $sponsorshipCode->setChildNumber(0);

        $user->setSponsorship($sponsorshipCode);

        $entityManager->persist($user);
        $entityManager->flush();

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($sponsorshipCode, Response::HTTP_CREATED);
    }

    /**
     * Creates a SponsorshipCode resource
     * @Rest\Patch("/sponsorshipCode/{userId}")
     * @param Request $request
     * @param User $userId
     * @return View
     */
    public function patchSponsorshipCode(Request $request, User $userId): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);
        $sponsorship = $user->getSponsorshipCode();
        if (!$user->getSponsorshipCode()) {
            return View::create(['message' => "sponsorship for user " + $userId +  "doesn't exist"], Response::HTTP_NOT_FOUND);
        }

        $sponsorship->setSponsorshipCode($request->get('sponsorshipCode'));

        $entityManager->persist($sponsorship);
        $entityManager->flush();

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($sponsorship, Response::HTTP_CREATED);
    }

    /**
     * Creates a SponsorshipCode resource
     * @Rest\Get("/checkSponsorshipCode/{userId}/{sponsorshipCode}")
     * @param Request $request
     * @param int $userId
     * @param string $sponsorshipCode
     * @return View
     */
    public function checkSponsorshipCode(Request $request, int $userId, string $sponsorshipCode): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);
        if ($user->getSponsorshipCode()->getSponsorshipchecked()) {
            return View::create(['message' => "User with id  " . $userId .  "already use your sponsorship code"], Response::HTTP_NOT_FOUND);
        }

        $sponsorship = $entityManager->getRepository(SponsorshipCode::class)->findOneBy(['sponsorshipCode' => $sponsorshipCode]);

        $userWhoGetTheSponsorShipCode = $entityManager->getRepository(User::class)->findOneBy(['sponsorshipCode' => $sponsorship]);

        if (!$user) {
            return View::create(['message' => "User with id  " . $userId .  "doesn't exist"], Response::HTTP_NOT_FOUND);
        }

        if (!$sponsorshipCode) {
            return View::create(['message' => "Code with value " . $sponsorship->getSponsorshipCode() .  "doesn't exist"], Response::HTTP_NOT_FOUND);
        }


        $userChildNumber = $sponsorship->getChildNumber();
        $userChallengePoint = $userWhoGetTheSponsorShipCode->getChallengePoint();

        $userWhoGetTheSponsorShipCode->setChallengePoint($userChallengePoint + 100);
        $sponsorship->setChildNumber($userChildNumber + 1);

        if ($user->getSponsorshipCode()) {
            $user->getSponsorshipCode()->setSponsorshipchecked(true);
            $user->getSponsorshipCode()->setPartnership($userWhoGetTheSponsorShipCode);

        } else {
            $childUserSponsorShip = new SponsorshipCode();
            $childUserSponsorShip->setSponsorshipchecked(true);
            $childUserSponsorShip->setChildNumber(0);
            $childUserSponsorShip->setSponsorshipCode(null);
            $childUserSponsorShip->setPartnership($userWhoGetTheSponsorShipCode);
            $user->setSponsorship($childUserSponsorShip);
        }

        $entityManager->persist($user);
        $entityManager->persist($userWhoGetTheSponsorShipCode);
        $entityManager->flush();

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($sponsorship, Response::HTTP_CREATED);
    }

}
