<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Entity\Stats;
use App\Core\EntityManager;
use App\Entity\Agent;
use App\Entity\Events;
use Doctrine\Common\Util\Debug;


class StatsUploadController extends AbstractController
{
    public function upload()
    {
        //Comprobacion de log in
        if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
            echo "No ha iniciado sesion";
            echo "<br>";
            echo '<a href="/">Iniciar Sesión</a>';
            die();
        }

        $em = (new EntityManager())->get();

        $agentRepository = $em->getRepository(Agent::class);
        $agentInfo = $agentRepository->findOneBy(['agent_name' => $_SESSION['agentname']]);

        $eventsRepository = $em->getRepository(Events::class);
        $events = $eventsRepository->findAll();


        //Traemos la informacion de los Events para despues pasarla a la template para que aparezcan los nombres de los diferentes eventos

        $this->render("uploadstats.html", [
            "Events" => $events,
            "Agent" => $agentInfo
        ]);


        if (isset($_POST["upload"])) {
            if ($_POST["stats"]) {
                //Comprobamos que no se haya seleccionado ningun evento y por tanto se hará la insercion en Stats
                if ($_POST["eventId"] == "none") {

                    if ($agentRepository->doUploadStats($_POST["stats"], $agentInfo->getAgent_name()) == 0) {
                        $error = $agentRepository->getError_type();
                        echo "<br> Error: " . $error['msg'];
                    } else {
                        echo "<br>¡Estadisticas subidas correctamente!";
                        echo "<br>Recordatorio: No corresponden a ningun evento";
                    }
                } else {

                    if ($agentRepository->doUploadStatsEvents($_POST["stats"], $agentInfo->getAgent_name(), $_POST["eventId"]) == 0) {
                        $error = $agentRepository->getError_type();
                        echo "<br> Error: " . $error['msg'];
                    } else {
                        echo "<br>¡Estadisticas subidas correctamente!";
                        echo "<br>Recordatorio: Las estadisticas se han subido relacionadas al evento " . $eventsRepository->findOneBy(['id_event' => $_POST["eventId"]])->getName();
                    }
                }
            } else {
                echo 'No hay datos para subir';
            }
        }
    }
}
