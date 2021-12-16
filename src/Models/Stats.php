<?php

namespace App\Models;

use App\Core\Interfaces\IDataBase;

class Stats
{
    private IDatabase $database;
    public function __construct(IDatabase $database)
    {
        $this->database = $database;
    }

    private function insertUploadInfo($datosBasicos, $agentid)
    {
        $sqlUpload = "INSERT INTO uploads (date, time, id_agent, time_span) VALUES('" . $datosBasicos[3] . "', '" . $datosBasicos[4] . "', '" . $agentid . "', '" . $this->getSpanId($datosBasicos[0]) . "')";
        return $this->database->actionSQL($sqlUpload);
    }

    private function insertStats($cabecerasStatsSQL, $agentid, $datosStatsSQL)
    {
        $sqlStats = "INSERT INTO stats (id_upload, id_agent, $cabecerasStatsSQL) VALUES (" . $this->getLastUploadId() . ", " . $agentid . ", " . $datosStatsSQL . ")";
        return $this->database->actionSQL($sqlStats);
    }

    public function getBasicInfoOf($agentname)
    {
        if (isset($agentname)) {
            $sql = "SELECT * FROM agent WHERE agent_name ='" . $agentname . "'";
            $query = $this->database->executeSQL($sql);
            return $query[0];
        }
    }

    public function getStatsOf($agentname)
    {
        if (isset($agentname)) {
            $sql = "SELECT agent.agent_name, agent.faction, stats.* FROM stats INNER JOIN agent ON agent.id_agent = stats.id_agent WHERE agent.agent_name = '" . $agentname . "'";
            $query = $this->database->executeSQL($sql);
            $returned = ($query) ? $query[0] : NULL;
            return $returned;
        }
    }

    public function getAgentId($agentname)
    {
        $sql = "SELECT id_agent FROM agent WHERE agent_name = '" . $agentname . "'";
        $query = $this->database->executeSQL($sql);
        return $query[0]['id_agent'];
    }

    public function getLastUploadId()
    {
        $sql = "SELECT MAX(id_upload) as maxid FROM uploads";
        $query = $this->database->executeSQL($sql);
        return intval($query[0]["maxid"]);
    }

    public function getSpanId($timespan)
    {
        $sql = "SELECT id_span FROM span WHERE time_span = '" . $timespan . "'";
        $query = $this->database->executeSQL($sql);
        return intval($query[0]["id_span"]);
    }

    public function getColumnNames($table){
        $sql = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='ingress' AND `TABLE_NAME`='". $table ."'";
        $query = $this->database->executeSQL($sql);
        return $query;
    }

    public function getStatsRankingFilteredBy($parameter){
        $sql = "SELECT agent.agent_name, stats.".$parameter." FROM stats INNER JOIN agent ON stats.id_agent = agent.id_agent GROUP BY agent.agent_name ORDER BY stats.".$parameter." DESC";
        $query = $this->database->executeSQL($sql);
        return $query;
    }

    public function uploadStats($rawStats)
    {

        // TRATAMIENTO DEL INPUT DE ESTADISTICAS PARA AÑADIRLO A UNA SECUENCIA SQL


        $stats_general = explode("\n", $rawStats);
        $stats_cabecera = explode("\t", $stats_general[0]);
        $stats_datos = explode("\t", $stats_general[1]);

                //Elimina el ultimo elemento de las estadisticas si este esta vacio
        isset($stats_datos[count($stats_datos) - 1]) ? array_pop($stats_datos) : NULL  ;


        $cabecerasBasicas = array_slice($stats_cabecera, 0, 5);
        $cabecerasStats = array_slice($stats_cabecera, 5);
        $datosBasicos = array_slice($stats_datos, 0, 5);
        $datosStats = array_slice($stats_datos, 5);


                //Sustituimos espacios por _ en las cabeceras para que el SQL coincida con la bbdd
                //Ademas si la cabeceras contiene un parentesis, se entrecomilla para evitar errores con la insercion
        foreach ($cabecerasStats as $key => $value) {
            $cabecerasStats[$key] = str_replace(" ", "_", $cabecerasStats[$key]);
            if (strpos($cabecerasStats[$key], "(") !== false) {
                $cabecerasStats[$key] = "`" . $cabecerasStats[$key] . "`";
            }
        }

        // $CabecerasBasicasSQL = implode(", ", $cabecerasBasicas);
        $cabecerasStatsSQL = implode(", ", $cabecerasStats);
        // $datosBasicosSQL = implode("', '", $datosBasicos);
        $datosStatsSQL = implode(", ", $datosStats);

                //Eliminamos la ultima coma y espacio sobrante de las cabeceras en la sentencia SQL
        $cabecerasStatsSQL = substr($cabecerasStatsSQL, 0, -3);


        $agentid = $this->getAgentId($datosBasicos[1]);
        

        // INSERTS

            if($this->insertUploadInfo($datosBasicos, $agentid) && $this->insertStats($cabecerasStatsSQL, $agentid, $datosStatsSQL)){
                echo "Estadisticas subidas correctamente";
                return true;
            }else {
                echo " <br> Error al subir las estadisticas, es posible que los datos introducidos no sean correctos";
                return false;
    }

}
}
    // public function insertUploadInfo($agentname, $timespan = 1)
    // {
    //     $agentid = getAgentId($agentname);
    //     $sql = "INSERT INTO uploads (date, time, id_agent, time_span) VALUES(DATE(NOW()), TIME_FORMAT(TIME(NOW()),'%H:%i:%S'), " . $agentid . ", " . $timespan . ")";
    //     return $this->database->actionSQL($sql);
    // 


                    /* TEST PARA LEER DATOS*/
                // foreach ($stats_cabecera as $key => $value) {
                //     echo " Dato: " . $stats_datos[$key] . "    Cabecera: " . $value . "   Posicion: " . $key;
                //     echo "<br>";
                // }
                