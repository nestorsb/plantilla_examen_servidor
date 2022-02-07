<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Entity\Events;
use App\Core\EntityManager;
use App\Entity\Stats;
use App\Entity\StatsEvents;
use Doctrine\Common\Util\Debug;


class EventParticipantsController extends AbstractController
{
    public function showeventparticipants($id)
    {
        //Comprobacion de log in
        if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
            echo "No ha iniciado sesion";
            echo "<br>";
            echo '<a href="/">Iniciar Sesión</a>';
            die();
        }

        $em =  (new EntityManager())->get();
        $eventRepository = $em->getRepository(Events::class);

        //Obtenemos los datos del evento seleccionado
        $event = $eventRepository->findOneBy(["id_event" => $id]);
        //Obtenemos las statsEvents del evento seleccionado
        $statsEvent = $event->getStatEvents();



        $statsEventsRepository = $em->getRepository(StatsEvents::class);
        $statsEventsRepository->doGroupByInStatsEvents($statsEvent);






        $this->render("eventparticipants.html", [
            "event" => $event,
            "statsEvent" => $statsEvent
        ]);
    }
}
