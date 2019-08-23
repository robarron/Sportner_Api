<?php

namespace App\Controller;

use App\Entity\Feed;
use App\Entity\FeedComment;
use App\Entity\MatchProposition;
use App\Entity\UserMatch;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;

class FeedController extends AbstractController
{
    /**
     * @Rest\Get("/feeds/{userId}")
     * @param int $userId
     * @return View
     * @throws EntityNotFoundException
     */
    public function getFeeds(int $userId): View
    {
        $moisfrancais = [
            1  => "janvier",
            2  => "février",
            3  => "mars",
            4  => "avril",
            5  => "mai",
            6  => "juin",
            7  => "juillet",
            8  => "août",
            9  => "septembre",
            10 => "octobre",
            11 => "novembre",
            12 => "décembre",
        ];

        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $userId]);

        if (!$user) {
            throw new EntityNotFoundException('User with id '.$userId.' does not exist !');
        }

        $userMatchs = $entityManager->getRepository(UserMatch::class)->getAllUserMatches($userId);

        if (!$userMatchs) {
            throw new EntityNotFoundException('User with id '.$userId.' does not have match yet !');
        }

        $secondUsersId = [];

        foreach ($userMatchs as $userMatch) {
            if ($userMatch->getUser()->getId() != $userId) {
                $secondUsersId[] = $userMatch->getUser()->getId();
            } else {
                $secondUsersId[] = $userMatch->getSecondUser()->getId();
            }
        }

        $feeds = $entityManager->getRepository(Feed::class)->getFeeds($secondUsersId);

        if (!$feeds) {
            throw new EntityNotFoundException('you have not feed !');
        }

        $commentsTabResult = [];
        $feedTabResult = [];

        $currentDate = new \DateTime();

        $comments = [];

        foreach ($feeds as $feed) {

            $comments = $entityManager->getRepository(FeedComment::class)->findBy(["feed" => $feed->getId()], ["createdAt" => "DESC"], 15);

            $createdAtFormatted = $feed->getCreatedAt()->format('j') . ' ' . $moisfrancais[$feed->getCreatedAt()->format('n')];

            $item = [];

            $item["id"] = $feed->getId();
            $item["content"] = $feed->getContent();
            $item["user_name"] = $feed->getUser()->getFirstName() . ' ' .$feed->getUser()->getLastName();
            $item["user_profil_pic"] = $feed->getUser()->getImages() ? $feed->getUser()->getImages()->getProfilPic() : null;
            $item["createdAt"] = $createdAtFormatted;
            $item["likes"] = $feed->getLikes();
            $item["time_spend_since_creation_in_minute"] = $currentDate->diff($feed->getCreatedAt())->format('%i');
            $item["time_spend_since_creation_in_hour"] = $currentDate->diff($feed->getCreatedAt())->format('%h');
            $item["time_spend_since_creation_in_day"] = $currentDate->diff($feed->getCreatedAt())->format('%d');

            $feedTabResult[] = $item;
        }

//        if ($comments)
//        {
//
//            foreach ($comments as $comment) {
//
//                $item = [];
//
//                $item["comment_id"] = $comment->getId();
//                $item["comment_time_spend_since_creation_in_minute"] = $currentDate->diff($comment->getCreatedAt())->format('%i');
//                $item["comment_time_spend_since_creation_in_hour"] = $currentDate->diff($comment->getCreatedAt())->format('%h');
//                $item["comment_time_spend_since_creation_in_day"] = $currentDate->diff($comment->getCreatedAt())->format('%d');
//                $item["comment_content"] = $comment->getContent();
//                $item["comment_user_name"] = $comment->getUser()->getFirstName() . ' ' .$comment->getUser()->getLastName();
//                $item["comment_user_profil_pic"] = $comment->getUser()->getImages() ? $comment->getUser()->getImages()->getProfilPic() : null;
//
//                $commentsTabResult[] = $item;
//
//            }
//        }

//        $formatted = array_merge($feedTabResult, $commentsTabResult);
        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($feedTabResult, Response::HTTP_OK);
    }

    public function dateDiff($date1, $date2){
        $diff = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
        $retour = array();

        $tmp = $diff;
        $retour['second'] = $tmp % 60;

        $tmp = floor( ($tmp - $retour['second']) /60 );
        $retour['minute'] = $tmp % 60;

        $tmp = floor( ($tmp - $retour['minute'])/60 );
        $retour['hour'] = $tmp % 24;

        $tmp = floor( ($tmp - $retour['hour'])  /24 );
        $retour['day'] = $tmp;

        return $retour;
    }

    /**
     * Creates a User resource
     * @Rest\Patch("/add_like_to_feed")
     * @param Request $request
     * @return View
     * @throws EntityNotFoundException
     */
    public function addLikeToFeed(Request $request): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $feed = $entityManager->getRepository(Feed::class)->findOneBy(["id" => $request->get('feedId')]);

        if (!$feed) {
            throw new EntityNotFoundException('Feed with id ' . $request->get('feedId') . ' does not exist!');
        }

        $feed->setLikes($request->get('likes'));

        $entityManager->persist($feed);
        $entityManager->flush();

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($feed->getLikes(), Response::HTTP_CREATED);
    }

    /**
     * Creates a User resource
     * @Rest\Get("/likes/{feedId}")
     * @param Request $request
     * @param $feedId
     * @return View
     * @throws EntityNotFoundException
     */
    public function getLikes(Request $request, $feedId): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $feed = $entityManager->getRepository(Feed::class)->findOneBy(["id" => $feedId]);

        if (!$feed) {
            throw new EntityNotFoundException('Feed with id ' . $request->get('feedId') . ' does not exist!');
        }

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($feed->getLikes(), Response::HTTP_CREATED);
    }
}
