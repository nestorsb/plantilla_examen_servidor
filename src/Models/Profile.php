<?php

namespace App\Models;

use App\Core\Interfaces\IDataBase;
use Exception;
use Throwable;

class Profile
{
    public function __construct(IDatabase $database)
    {
        $this->database = $database;
    }

    public function validateStats($rawStats){

        // var_dump($rawStats);
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";

        $stats_general = explode("\n", $rawStats);

        // var_dump($stats_general);
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";

        $stats_cabecera = explode("\t", $stats_general[0]);

        // var_dump($stats_cabecera);
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";


        $stats_datos = explode("\t", $stats_general[1]);

        // var_dump($stats_datos);
        // echo "<br>";
        // echo "<br>";
        // echo "<br>";


        foreach($stats_cabecera as $key => $value){
            echo " Dato: ". $stats_datos[$key] ."    Cabecera: " . $value . "   Posicion: ". $key;
            echo "<br>";
        }
    }
}

