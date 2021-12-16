<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Models\Stats;
use App\Core\DataBase;

class StatsUploadController extends AbstractController
{
    public function upload()
    {
        $stats = new Stats(new DataBase);

        $this->render("uploadstats.html", []);

        if (isset($_POST["upload"])) {
             if($_POST["stats"]) {
                $stats->uploadStats($_POST["stats"]);
             } else {
                 echo 'No hay datos para subir' ;
             }
        }

    }

}
