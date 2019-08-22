<?php

namespace App\Controller;

use App\Entity\UserMatch;
use Doctrine\ORM\EntityNotFoundException;
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
     * @param User $userId
     * @param User $secondUserId
     * @return View
     */
    public function UserHasMatch(User $userId, User $secondUserId): View
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

    /**
     * Retrieves all User matches resource by his id
     * @Rest\Get("/all_matches/{userId}", requirements={"id"="\d+"})
     * @param int $userId
     * @return View
     * @throws EntityNotFoundException
     */
    public function getAllUserMatches(int $userId): View
    {

        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findBy(['id' => $userId]);
        $userAllMatches = $entityManager->getRepository(UserMatch::class)->getAllUserMatches($userId);

        if (!$user) {
            throw new EntityNotFoundException('User with id '.$userId.' does not exist!');
        }

        if (!$userAllMatches) {
            throw new EntityNotFoundException('User with id '.$userId.' hasn\'t match yet!');
        }

        $formatted = [];

        foreach ($userAllMatches as $userMatch) {
            $secondUser = null;
            if ($userMatch->getUser()->getId() != $userId)
            {
                $secondUser = $userMatch->getUser();
            } else {
                $secondUser = $userMatch->getSecondUser();
            }

            $item = [];

            $item["id"] = $userMatch->getId();
            $item["second_user_id"] = $secondUser->getId();
            $item["profil_pic"] = $secondUser->getImages() ? $secondUser->getImages()->getProfilPic() : null;
            $item["user_first_name"] = $secondUser->getFirstName();
            $item["user_last_name"] = $secondUser->getLastName();
            $item["user_id"] = $secondUser->getId();

            $formatted[] = $item;
        }

        return View::create($formatted, Response::HTTP_OK);
    }
}
