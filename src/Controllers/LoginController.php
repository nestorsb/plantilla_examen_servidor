<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Entity\Agent;
use App\Core\EntityManager;


class LoginController extends AbstractController
{
  public function showlogin()
  {

    $agent = (new EntityManager())->get();
    $agentRepository = $agent->getRepository(Agent::class);

    $this->render("login.html",[]);

    if(isset($_POST["login"])){
      if($agentRepository->doLogin($_POST["username"], $_POST["password"])){
        $this->sessionManager->set("agentname", $_POST["username"]);
        header('Location: /userprofile');
        echo "nice";
      }else {
        echo "Usuario o contraseña incorrectos";
      }
    }
  }
}
