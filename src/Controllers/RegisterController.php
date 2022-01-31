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
    $agent = new Agent();
    $agentRepository = $entityManager->getRepository(Agent::class);

    //Cargamos al template
    $this->render("register.html", []);

    if (isset($_POST["register"])) 
    {
      if (!isset($_POST["username"]) || !isset($_POST["password"]) || !isset($_POST["faction"]))
      //Comprobacion de que los datos pasados por POST existan.
      {
        echo 'Introduzca todos los datos para registrarse correctamente.';
        return false;
      }

      if($agentRepository->avaliableNameCheck($_POST["username"]))
      {
        return true;
      }else{
        echo 'Ese nombre ya existe.';
        return false;
      }

      //Setters de los valores para la insercion a bbdd
      $agent->setAgent_name($_POST["username"]);
      $agent->setPassword(password_hash($_POST["password"], PASSWORD_DEFAULT, ['cost' => 10])); //Faltaria colocar las opciones de seguridad del hash (HASH y COST) en otro sitio mas accesible, recuerda self::HASH, ['cost' => self::COST]
      $agent->setFaction($_POST["faction"]);
      
      //Insercion a bbdd
      $entityManager->persist($agent);
      $entityManager->flush();
      header("location:/");

    }
  }
}






// class RegisterController extends AbstractController
// {
//   public function showregister()
//   {
//     $agent = new Agent(new DataBase);

//     $this->render("register.html", []);
    
//     if(isset($_POST["register"])){
//       $agent->register($_POST["username"],$_POST["password"],$_POST["faction"]); 
//     }
//   }
// }