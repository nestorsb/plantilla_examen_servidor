<?php

namespace App\Models;

use App\Core\Interfaces\IDataBase;
use Exception;
use Throwable;

class Agent
{
    private IDatabase $database;
    const HASH = PASSWORD_DEFAULT;
    const COST = '10';

    public function __construct(IDatabase $database)
    {
        $this->database = $database;
    }


    public function validateCredencials($agentname, $password)
    {
        /** IMPORTACION DE DATOS DEL AGENT DESDE BBDD */
        if (isset($agentname) && isset($password)) {
            $sql = "SELECT * FROM agent WHERE agent_name ='" . $agentname . "'";
            $query = $this->database->executeSQL($sql);
        }


        /** VALIDACION AGENTNAME */
        if (isset($query[0]["agent_name"])) {
            if (!($query[0]["agent_name"] === $agentname)) {
                return false;
            }
        }

        /** VALIDACION PASSWORD */
        if (isset($query[0]["password"])) {
            if (password_verify($password, $query[0]["password"])) {
                if (password_needs_rehash($query[0]["password"], self::HASH, ['cost' => self::COST])) {
                    $this->setPasswordHash($agentname, $query[0]["password"]);
                }
                return true;
            } else return false;
        } else return false;
    }
    public function login($agentname, $password)
    {

        if ($this->validateCredencials($agentname, $password)) {
            session_unset();
            session_destroy();
            session_start();
            $_SESSION["agentname"] = $agentname;
            $_SESSION["login"] = true;
            echo header('Location:/userprofile');
        } else
            echo "Usuario o Contraseña Incorrectos";
    }


    public function getPasswordHash($password)
    {
        $password = password_hash($password, self::HASH, ['cost' => self::COST]);
        return $password;
    }
    public function updatePassword($agentname, $passwordHash)
    {
        $sql = "UPDATE agent SET password='$passwordHash' WHERE agent_name=$agentname";
        return $this->database->actionSQL($sql);
    }
    public function setPasswordHash($agentname, $password)
    {
        return $this->updatePassword($agentname, $this->getPasswordHash($password));
    }
    public function avaliableNameCheck($agentname)
    {
        $sql = "SELECT agent_name FROM agent WHERE agent_name ='" . $agentname . "'";
        $query = $this->database->executeSQL($sql);
        if (strtolower($query[0]["agent_name"]) == strtolower($agentname)) {
            return false;
        } else
            return true;
    }
    public function register($agentname, $password, $faction)
    {
        if (isset($agentname) && isset($password) && isset($faction)) {

            if ($this->avaliableNameCheck($agentname)) {
                $password = $this->getPasswordHash($password);

                switch ($faction) {
                    case "R":
                        $faction = "Resistance";
                        break;
                    case "E":
                        $faction = "Enlightened";
                        break;
                }

                $sql = "INSERT INTO agent (agent_name, password, faction ) VALUES('" . $agentname . "','" . $password . "','" . $faction . "')";

                if ($this->database->actionSQL($sql) == 1) {
                    header('Location:/');
                    return $this->database->actionSQL($sql);
                }else echo "Error al registrarse.";
            } else echo "El nombre ya existe.";
        } else
            echo "Datos introducidos incorrectamente, revise todos los campos.";
    }
}



//en el register, si te intentas registrar con un nombre que ya existe, te da este aviso, 
//pero si te intentas registrar con un nombre que ya existe pero cambias a mayusculas o minusculas,
//te da el error "Error al registrarse" 
