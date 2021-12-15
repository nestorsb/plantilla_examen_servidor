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

    public function getBasicInfoOf($agentname){
        if (isset($agentname)) {
            $sql = "SELECT * FROM agent WHERE agent_name ='" . $agentname . "'";
            $query = $this->database->executeSQL($sql);
            return $query[0];
        }
    }

    public function getStatsOf($agentname){
        if (isset($agentname)) {
            $sql = "SELECT agent.agent_name, agent.faction, stats.* FROM stats INNER JOIN agent ON agent.id_agent = stats.id_agent WHERE agent.agent_name = '" . $agentname . "'";
            $query = $this->database->executeSQL($sql);
            return $query;
        }
    }




    // public function findCustomersByCity($id)
    // {
    //     $sql = "SELECT * FROM customer WHERE city_id=$id";
    //     $result = $this->database->executeSQL($sql);
    //     return $result;
    // }

    // public function findCustomerById($id)
    // {
    //     $sql = "SELECT * FROM customer WHERE customer_id=$id";
    //     $result = $this->database->executeSQL($sql);
    //     $result = array_shift($result);
    //     switch($result["plan"]){
    //         case "basic":
    //             $price = 15;
    //             break;
    //         case "premium":
    //             $price = 22;
    //             break;
    //         case "senior":
    //             $price = 17;
    //             break;
    //     }
    //     $result["invoice"] = $price * $result["services"];
    //     return $result;
    // }

    // public function dismiss($id)
    // {
    //     $sql = "DELETE FROM customer WHERE customer_id = $id";
    //     return $this->database->actionSQL($sql);
    // }
}
