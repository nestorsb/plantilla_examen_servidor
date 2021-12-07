<?php

namespace App\Models;

use App\Core\Interfaces\IDataBase;

class Customer
{
    private IDatabase $database;
    public function __construct(IDatabase $database)
    {
        $this->database = $database;
    }

    public function findCustomersByCity($id)
    {
        $sql = "SELECT * FROM customer WHERE city_id=$id";
        $result = $this->database->executeSQL($sql);
        return $result;
    }

    public function findCustomerById($id)
    {
        $sql = "SELECT * FROM customer WHERE customer_id=$id";
        $result = $this->database->executeSQL($sql);
        $result = array_shift($result);
        switch($result["plan"]){
            case "basic":
                $price = 15;
                break;
            case "premium":
                $price = 22;
                break;
            case "senior":
                $price = 17;
                break;
        }
        $result["invoice"] = $price * $result["services"];
        return $result;
    }

    public function dismiss($id)
    {
        $sql = "DELETE FROM customer WHERE customer_id = $id";
        return $this->database->actionSQL($sql);
    }
}
