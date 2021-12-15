<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Models\Agent;
use App\Core\DataBase;

class RegisterController extends AbstractController
{
  public function showregister()
  {
    $agent = new Agent(new DataBase);

    $this->render("register.html", []);
    
    if(isset($_POST["register"])){
      $agent->register($_POST["username"],$_POST["password"],$_POST["faction"]); 
    }
  }
}
