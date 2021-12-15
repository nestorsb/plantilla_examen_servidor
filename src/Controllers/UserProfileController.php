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
        // var_dump($stats->getStatsOf($agentname));
        // if (empty($stats->getStatsOf($agentname))){
        //     echo "si";
        // };

        $this->render("profile.html", [
            "stats"=> empty($stats->getStatsOf($agentname)) ? $stats->getStatsOf($agentname) : NULL,
            "basicinfo" => $stats->getBasicInfoOf($agentname)
        ]);
    }
}
