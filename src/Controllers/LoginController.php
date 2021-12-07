<?php

namespace App\Controllers;

use App\Views\LoginView;
use App\Models\Agent;
use App\Core\DataBase;

class LoginController
{
  public function showlogin()
  {

    $agent = new Agent(new DataBase);
    new LoginView();

    if(isset($_POST["login"])){
      $agent->login($_POST["username"], $_POST["password"]);
    }
  }
}
