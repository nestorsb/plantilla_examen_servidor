<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Entity\Agent;
use App\Entity\stats;
use App\Core\EntityManager;
use App\Entity\StatsEvents;
use Doctrine\Common\Util\Debug;


class UserProfileController extends AbstractController
{
    public function showprofile(){

        //Comprobacion de log in
        if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
            echo "No ha iniciado sesion";
            echo "<br>";
            echo '<a href="/">Iniciar Sesión</a>';
            die();
        }

        
        $em =  (new EntityManager())->get();
        $agentRepository = $em->getRepository(Agent::class);
        $statsEventsRepository = $em->getRepository(StatsEvents::class);
        $agent = $agentRepository->findOneBy(['agent_name'=>$_SESSION["agentname"]]);
        // $statsEvents = $statsEventsRepository->findOneBy(['agent_name'=>$agent->getAgent_name()]);
        
        if(is_null($agent->getStats())){
            echo "Aun no hay estadisticas de este agente";
        }            
        
        $this->render("profile.html", [
            "agent"=> $agent
        ]);

        //Log out
        if(isset($_POST["logout"])){
            unset($_SESSION["login"]);
            unset($_SESSION["agentname"]);
            session_destroy();
            header('location:/');
        }
    }
    
    // public function getPropertyNamesOfStatsEvents()
    // {
        //   $statprueba = new StatsEvents;
        //   $arrayRawProperties = (array)$statprueba;
        //   $goodPropertiesNames = array();
        //   foreach ($arrayRawProperties as $key => $value) {
            //     $arrayInfoi = substr($key, 24); // el objetivo es quitar "App\Entity\statsEvents" de las $key, por eso 25
            //     array_push($goodPropertiesNames, $arrayInfoi);
    //   }
    //   //Quitamos del array los nombres de las propiedades que no vamos a mostrar en el HTML
    //   // $goodPropertiesNames = array_diff($goodPropertiesNames, array('id_stats', 'id_upload'));
  
    //   return $goodPropertiesNames;
    // }
  
}
