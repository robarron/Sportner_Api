<?php

namespace App\Controller;

use App\Entity\UserMatch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;

class UserMatchController extends AbstractController
{
    /**
     * Knows if 2 users has match
     * @Rest\GET("/user_has_match/{userId}/{secondUserId}")
     * @param Request $request
     * @param User $userId
     * @param User $secondUserId
     * @return View
     */
    public function UserHasMatch(Request $request, User $userId, User $secondUserId): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);

        $userHasMatch = $entityManager->getRepository(UserMatch::class)->findOneBy(['user' => $userId, 'secondUser' => $secondUserId]);

        if (empty($user)) {
            return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        if (empty($userHasMatch)) {
            return View::create(['message' => 'thoses Users doesn\'t match'], Response::HTTP_NOT_FOUND);
        }

        $formatted = [
            "id" => $userHasMatch->getId()
        ];
        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($formatted, Response::HTTP_CREATED);
    }
}
