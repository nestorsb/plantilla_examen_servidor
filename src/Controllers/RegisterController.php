<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Entity\Agent;
use App\Core\EntityManager;

class RegisterController extends AbstractController
{
  public function register()
  {
    $entityManager = (new EntityManager())->get();
    $agentRepository = $entityManager->getRepository(Agent::class);

    //Cargamos al template
    $this->render("register.html", []);

    if (isset($_POST["register"])) {
      if (!isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["faction"])) {
        //Comprobacion de que los datos pasados por POST existan.
        echo 'Introduzca todos los datos para registrarse correctamente.';
        return false;
      }

      if ($agentRepository->doRegister($_POST["username"], $_POST["password"], $_POST["faction"])) {
        echo 'Registrado correctamente';
      }
    }
  }
}
