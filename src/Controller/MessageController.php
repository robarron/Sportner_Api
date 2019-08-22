<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\UserMatch;
use DateTime;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;

class MessageController extends AbstractController
{
    /**
     * Retrieves User conversation by his id
     * @Rest\Get("/conversation/{senderId}/{receptorId}", requirements={"id"="\d+"})
     * @param int $senderId
     * @param int $receptorId
     * @return View
     * @throws EntityNotFoundException
     */
    public function getUserConversation(int $senderId, int $receptorId): View
    {

        $entityManager = $this->getDoctrine()->getManager();

        $user = $entityManager->getRepository(User::class)->findBy(['id' => $senderId]);

        $userConversation = $entityManager->getRepository(Message::class)->getUserConversation($senderId, $receptorId);

        if (!$user) {
            throw new EntityNotFoundException('User with id '.$senderId.' does not exist!');
        }

        if (!$userConversation) {
            throw new EntityNotFoundException('User with id '.$senderId.' hasn\'t conversation yet!');
        }

        $formatted = [];

        foreach ($userConversation as $message) {
            //1 = sender - 2 = receptor
            $userConvId = null;
            if ($message->getSender()->getId() == $senderId)
            {
                $userConvId = 1;
            } else {
                $userConvId = 2;
            }

            $item = [];

            $item["id"] = $message->getId();
            $item["text"] = $message->getText();
            $item["createdAt"] = $message->getCreatedAt();
            $item["user"] = [
                "id" => $userConvId,
                "name" => $message->getSender()->getFirstName() . ' ' . $message->getSender()->getLastName(),
            ];

            $formatted[] = $item;
        }

        return View::create($formatted, Response::HTTP_OK);
    }

    /**
     * Creates a Message resource
     * @Rest\Post("/message")
     * @param Request $request
     * @return View
     */
    public function postUser(Request $request): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $sender = $entityManager->getRepository(User::class)->findOneBy(["id" => $request->get('sender_id')]);
        $receptor = $entityManager->getRepository(User::class)->findOneBy(["id" => $request->get('receptor_id')]);

        $message = new Message();
        $message->setCreatedAt(new DateTime());
        $message->setText($request->get('text'));
        $message->setSender($sender);
        $message->setReceptor($receptor);

        $entityManager->persist($message);
        $entityManager->flush();

        return View::create($message, Response::HTTP_CREATED);
    }

}
