<?php

namespace App\Controller;

use App\Entity\MatchProposition;
use App\Entity\UserMatch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;

class MatchPropositionController extends AbstractController
{
    /**
     * Creates a MatchProposition resource
     * @Rest\Post("/match_proposition/{userId}")
     * @param Request $request
     * @param User $userId
     * @return View
     */
    public function postMatchProposition(Request $request, User $userId): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);
        $proposedToUserId = $request->get('wanted_user');
        $proposedToUser = $entityManager->getRepository(User::class)->findOneBy(['id' => $proposedToUserId]);

        $userTargetPropositions = $entityManager->getRepository(MatchProposition::class)->GetTargetUserPropositions($userId, $proposedToUserId);

        if (empty($proposedToUser)) {
            return View::create(['message' => 'Wanted User not found'], Response::HTTP_NOT_FOUND);
        }

        if ($userTargetPropositions)
        {
            $matchProposition = new MatchProposition();
            $matchProposition->setUser($user);
            $matchProposition->setUserWanted($proposedToUser);

            $match = new UserMatch();
            $match->setUser($user);
            $match->setSecondUser($proposedToUser);

            $entityManager->persist($matchProposition);
            $entityManager->persist($match);
            $entityManager->flush();

            $formatted = [
                "id" => $matchProposition->getId(),
                "user_id" => $matchProposition->getUser()->getId(),
                "second_user_id" => $matchProposition->getUserWanted()->getId(),
            ];

            return View::create($formatted, Response::HTTP_CREATED);
        }

        $matchProposition = new MatchProposition();
        $matchProposition->setUser($user);
        $matchProposition->setUserWanted($proposedToUser);

        $entityManager->persist($matchProposition);
        $entityManager->flush();

        $formatted = [
            "id" => $matchProposition->getId(),
            "user_id" => $matchProposition->getUser()->getId(),
            "second_user_id" => $matchProposition->getUserWanted()->getId(),
        ];

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($formatted, Response::HTTP_CREATED);
    }
}
