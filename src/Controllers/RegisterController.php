<?php

namespace App\Controllers;

use App\Views\RegisterView;
use App\Models\Agent;
use App\Core\DataBase;

class RegisterController
{
  public function showregister()
  {
    $agent = new Agent(new DataBase);
    new RegisterView();
    
    if(isset($_POST["register"])){
      $agent->register($_POST["username"],$_POST["password"],$_POST["faction"]); // por aqui lo he dejado, ir a agent a hacer la funcion
    }
  }
}
