<?php

namespace App\Repository;

use App\Entity\Agent;
use App\Core\EntityManager;
use Doctrine\ORM\EntityRepository;

class TareasRepository extends EntityRepository{
    public function doLogin($name, $pass){
        $agente = $this->findOneBy(['agent_name'=>$name]);
        if(is_null($agente)||empty($agente)){
            return false;
        }else{
            return password_verify($pass, $agente->getPassword());
        }
    }
}