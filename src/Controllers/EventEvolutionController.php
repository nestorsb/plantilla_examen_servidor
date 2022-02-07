<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Entity\Events;
use App\Entity\Agent;
use App\Entity\StatsEvents;
use App\Core\EntityManager;
use App\Entity\Uploads;
use Doctrine\Common\Util\Debug;


class EventEvolutionController extends AbstractController
{
    public function showeventevolution($id)
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
        $agentRepository = $em->getRepository(Agent::class);
        $uploadRepository = $em->getRepository(Uploads::class);
        $StatsEventsRepository = $em->getRepository(StatsEvents::class);


        $agent = $agentRepository->findOneBy(['agent_name' => $_SESSION["agentname"]]);
        $event = $eventRepository->findOneBy(['id_event' => $id]);
        $statsEvent = $StatsEventsRepository->findBy(
            ['agent' => $agent, 'event' => $event],
            ['upload' => 'ASC']
        );


        //Comprobacion de que haya estadisticas subidas por el agente del evento en concreto
        $noData = false;
        if (!empty($statsEvent)) {
            $numberOfUploads = count($statsEvent);
            $this->render("eventevolution.html", [
                "agent" => $agent,
                "event" => $event,
                "firstStats" => $statsEvent[0],
                "lastStats" => $statsEvent[$numberOfUploads - 1],
                "noData" => $noData
            ]);
        } else {
            $noData = true;
            $this->render("eventevolution.html", [
                "noData" => $noData
            ]);
        }
    }
}
