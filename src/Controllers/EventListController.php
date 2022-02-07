<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Entity\Events;
use App\Core\EntityManager;


class EventListController extends AbstractController
{
    public function showeventlist()
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

        $events = $eventRepository->findAll();


        $this->render("eventlist.html", [
            "events" => $events
        ]);
    }
}
