<?php

namespace App\Controller;

use App\Entity\Feed;
use App\Entity\FeedComment;
use App\Entity\User;
use App\Entity\UserLikeComment;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;

class FeedCommentController extends AbstractController
{

    /**
     * @Rest\Get("/feed_comments/{userId}/{feedId}")
     * @param int $userId
     * @param int $feedId
     * @return View
     * @throws EntityNotFoundException
     */
    public function getFeedComments(int $userId, int $feedId): View
    {
        $entityManager = $this->getDoctrine()->getManager();
        $commentsTabResult = [];
        $currentDate = new \DateTime();

        $feed = $entityManager->getRepository(Feed::class)->findOneBy(['id' => $feedId]);

        if (!$feed) {
            throw new EntityNotFoundException('Feed with id ' . $feedId . ' does not exist !');
        }

        $comments = $entityManager->getRepository(FeedComment::class)->findBy(["feed" => $feedId], ["createdAt" => "DESC"], 15);

        if (!$comments) {
            throw new EntityNotFoundException('Feed with id '. $feedId . ' does not have comment yet !');
        } else
        {
            foreach ($comments as $comment) {

                $didLike = $entityManager->getRepository(UserLikeComment::class)->findOneBy(['user' => $userId, 'feedComment' => $comment->getId()]);

                $item = [];

                $item["comment_id"] = $comment->getId();
                $item["comment_time_spend_since_creation_in_minute"] = $currentDate->diff($comment->getCreatedAt())->format('%i');
                $item["comment_time_spend_since_creation_in_hour"] = $currentDate->diff($comment->getCreatedAt())->format('%h');
                $item["comment_time_spend_since_creation_in_day"] = $currentDate->diff($comment->getCreatedAt())->format('%d');
                $item["comment_content"] = $comment->getContent();
                $item["comment_user_name"] = $comment->getUser()->getFirstName() . ' ' .$comment->getUser()->getLastName();
                $item["comment_user_profil_pic"] = $comment->getUser()->getImages() ? $comment->getUser()->getImages()->getProfilPic() : null;
                $item["comment_likes"] = $comment->getLikes() ? $comment->getLikes() : 0;
                $item["did_like_comment"] = $didLike ? true : false;

                $commentsTabResult[] = $item;

            }
        }

        // In case our GET was a success we need to return a 200 HTTP OK response with the request object
        return View::create($commentsTabResult, Response::HTTP_OK);
    }

    /**
     * Creates a User resource
     * @Rest\Patch("/add_like_to_comment")
     * @param Request $request
     * @return View
     * @throws EntityNotFoundException
     */
    public function addLikeToComment(Request $request): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $request->get('userId')]);

        $feedComment = $entityManager->getRepository(FeedComment::class)->findOneBy(["id" => $request->get('comment_id')]);

        if (!$feedComment) {
            throw new EntityNotFoundException('Comment with id ' . $request->get('comment_id') . ' does not exist!');
        }

        $userLikeComment = new UserLikeComment;
        $userLikeComment->setUser($user);
        $userLikeComment->setFeedComment($feedComment);

        $feedComment->setLikes($request->get('likes'));

        $entityManager->persist($feedComment);
        $entityManager->persist($userLikeComment);
        $entityManager->flush();

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($feedComment->getLikes(), Response::HTTP_CREATED);
    }

    /**
     * Creates a User resource
     * @Rest\Post("/feed_comments")
     * @param Request $request
     * @return View
     * @throws EntityNotFoundException
     */
    public function postFeedComment(Request $request): View
    {
        $entityManager = $this->getDoctrine()->getManager();
        $currentDate = new \DateTime();

        $commentCreator = $entityManager->getRepository(User::class)->findOneBy(['id' => $request->get('userId')]);

        if (!$commentCreator) {
            throw new EntityNotFoundException('user with id '. $request->get('userId') . ' does not exist !');
        }

        $feedConcerned = $entityManager->getRepository(Feed::class)->findOneBy(['id' => $request->get('feedId')]);

        if (!$feedConcerned) {
            throw new EntityNotFoundException('feed with id '. $request->get('feedId') . ' does not exist !');
        }

        $feedComment = new FeedComment();
        $feedComment->setLikes(0);
        $feedComment->setCreatedAt($currentDate);
        $feedComment->setContent($request->get('commentInput'));
        $feedComment->setUser($commentCreator);
        $feedComment->setFeed($feedConcerned);

        $entityManager->persist($feedComment);
        $entityManager->flush();

        $formatted = [
            "comment_id" => $feedComment->getId(),
            "comment_time_spend_since_creation_in_minute" => 0,
            "comment_time_spend_since_creation_in_hour" => 0,
            "comment_time_spend_since_creation_in_day" => 0,
            "comment_content" => $request->get('commentInput'),
            "comment_user_name" => $commentCreator->getFirstName() . ' ' .$commentCreator->getLastName(),
            "comment_user_profil_pic" => $commentCreator->getImages() ? $commentCreator->getImages()->getProfilPic() : null,
            "comment_likes" => 0,
            "did_like_comment" => false,
        ];

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($formatted, Response::HTTP_CREATED);
    }
}