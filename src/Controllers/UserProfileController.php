<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Models\Stats;
use App\Core\DataBase;

class UserProfileController extends AbstractController
{
    public function showprofile(){
        $agentname = $this->sessionManager->get("agentname");
        $stats = new Stats(new DataBase);

        if($stats->getStatsOf($agentname)){
            $agentStats = $stats->getStatsOf($agentname);
        }else {
            $agentStats = NULL;
            echo "Aun no hay estadisticas de este agente";
        }
            

        $this->render("profile.html", [
            "stats"=> $agentStats,
            "basicinfo" => $stats->getBasicInfoOf($agentname)
        ]);
    }
}
