<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\MatchProposition;
use App\Entity\UserMatch;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;

class EventController extends AbstractController
{
    /**
     * get all top events
     * @Rest\Get("/top_events")
     * @return View
     */
    public function GetTopEvents(): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $topEvents = $entityManager->getRepository(Event::class)->getTopEvents();

        $moisfrancais = array ( 1 => "Janvier", "Février", "Mars", "Avril",
            "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre",
            "Décembre");
        $joursemainefrancais = array (0 => "Dimanche", "Lundi", "Mardi",
            "Mercredi", "Jeudi", "Vendredi", "Samedi");

        $topEventsResult = [];

        foreach ($topEvents as $topEvent) {

            $minute = $topEvent->getStartDate()->format('i');
            $heure = $topEvent->getStartDate()->format('G');
            $jour = $topEvent->getStartDate()->format('d');
            $mois = $topEvent->getStartDate()->format('n');
            $joursemaine = $topEvent->getStartDate()->format('w');

            $item = [];

            $item["id"] = $topEvent->getId();
            $item["city"] = $topEvent->getCity();
            $item["interested_number"] = $topEvent->getInterestedNumber();
            $item["is_top_event"] = $topEvent->getIsTopEvent();
            $item["organizer"] = $topEvent->getOrganizer();
            $item["participate_number"] = $topEvent->getParticipateNumber();
            $item["picture"] = $topEvent->getPicture();
            $item["place"] = $topEvent->getPlace();
            $item["sport_type"] = $topEvent->getSportType();
            $item["start_date"] = $joursemainefrancais[$joursemaine] . " " . $jour . " " .  $moisfrancais[$mois] . " à " . $heure . "H" . $minute;
            $item["ticketing_site_link"] = $topEvent->getTicketingSiteLink();
            $item["title"] = $topEvent->getTitle();

            $topEventsResult[] = $item;

        }

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($topEventsResult, Response::HTTP_CREATED);
    }

    /**
     * get all top events
     * @Rest\Get("/events")
     * @return View
     */
    public function GetAllEvents(): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $moisfrancais = array ( 1 => "Janvier", "Février", "Mars", "Avril",
            "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre",
            "Décembre");
        $joursemainefrancais = array (0 => "Dimanche", "Lundi", "Mardi",
            "Mercredi", "Jeudi", "Vendredi", "Samedi");

        $events = $entityManager->getRepository(Event::class)->findBy(["isTopEvent" => false], ["startDate" => "DESC"], 30);

        $eventsResult = [];

        foreach ($events as $event) {

            $minute = $event->getStartDate()->format('i');
            $heure = $event->getStartDate()->format('G');
            $jour = $event->getStartDate()->format('d');
            $mois = $event->getStartDate()->format('n');
            $joursemaine = $event->getStartDate()->format('w');

            $item = [];

            $item["id"] = $event->getId();
            $item["city"] = $event->getCity();
            $item["interested_number"] = $event->getInterestedNumber();
            $item["is_top_event"] = $event->getIsTopEvent();
            $item["organizer"] = $event->getOrganizer();
            $item["participate_number"] = $event->getParticipateNumber();
            $item["picture"] = $event->getPicture();
            $item["place"] = $event->getPlace();
            $item["sport_type"] = $event->getSportType();
            $item["start_date"] = $joursemainefrancais[$joursemaine] . " " . $jour . " " .  $moisfrancais[$mois] . " à " . $heure . "H" . $minute;
            $item["ticketing_site_link"] = $event->getTicketingSiteLink();
            $item["title"] = $event->getTitle();

            $eventsResult[] = $item;

        }

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($eventsResult, Response::HTTP_CREATED);
    }

    /**
     * Modify the interested number of the current Event
     * @Rest\Patch("/event_interested_number")
     * @param Request $request
     * @return View
     * @throws EntityNotFoundException
     */
    public function patchCurrentEventInterestedNumber(Request $request): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $eventItem = $entityManager->getRepository(Event::class)->findOneBy(['id' => $request->get('eventId')]);

        if (!$eventItem) {
            throw new EntityNotFoundException('event with id '. $request->get('eventId') . ' does not exist !');
        }


        $eventItem->setInterestedNumber($eventItem->getInterestedNumber() + 1);

        $entityManager->persist($eventItem);
        $entityManager->flush();

        $formatted = [
            "interested_number" => $eventItem->getInterestedNumber(),
        ];

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($formatted, Response::HTTP_CREATED);
    }

    /**
     * Creates a User resource
     * @Rest\Patch("/event_participated_number")
     * @param Request $request
     * @return View
     * @throws EntityNotFoundException
     */
    public function patchCurrentEventParticipatedNumber(Request $request): View
    {
        $entityManager = $this->getDoctrine()->getManager();

        $eventItem = $entityManager->getRepository(Event::class)->findOneBy(['id' => $request->get('eventId')]);

        if (!$eventItem) {
            throw new EntityNotFoundException('event with id '. $request->get('eventId') . ' does not exist !');
        }

        $eventItem->setParticipateNumber($eventItem->getParticipateNumber() + 1);

        $entityManager->persist($eventItem);
        $entityManager->flush();

        $formatted = [
            "participated_number" => $eventItem->getParticipateNumber(),
        ];

        // In case our POST was a success we need to return a 201 HTTP CREATED response
        return View::create($formatted, Response::HTTP_CREATED);
    }
}
