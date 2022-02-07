<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Entity\Agent;
use App\Core\EntityManager;


class LoginController extends AbstractController
{
  public function showlogin()
  {

    if(isset($_SESSION['login']) && $_SESSION['login'] == true){
      header('location: /userprofile');
    }


    $agent = (new EntityManager())->get();
    $agentRepository = $agent->getRepository(Agent::class);

    $this->render("login.html",[]);

    if(isset($_POST["login"])){
      if($agentRepository->doLogin($_POST["username"], $_POST["password"])){
        session_start();
        $this->sessionManager->set("agentname", $_POST["username"]);
        $this->sessionManager->set("login", true);
        header('Location: /userprofile');
      }else {
        echo "Usuario o contraseña incorrectos";
      }
    }
  }
}
