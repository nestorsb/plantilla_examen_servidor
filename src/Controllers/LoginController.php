<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Models\Agent;
use App\Core\DataBase;

class LoginController extends AbstractController
{
  public function showlogin()
  {

    $agent = new Agent(new DataBase);

    $this->render("login.html",[]);
    
    if(isset($_POST["login"])){
      $agent->login($_POST["username"], $_POST["password"]);
      $this->sessionManager->set("agentname", $_POST["username"]);;
    }
  }
}
