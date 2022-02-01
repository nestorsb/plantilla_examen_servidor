<?php
/**
 * Clase que extiende del EntityRepository donde podemos personalizar los métodos
 * que creamos necesitar añadiendo a los ya definidos por defecto.
 */

Namespace App\Repository;

use App\Entity\Agent;
use App\Core\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Por defecto hemos extendido los métodos:
 * find, findBy, findOneBy y findAll
 */
class AgentRepository extends EntityRepository{

    /**
     * También se pueden usar metodos como findBy****
     * donde **** es la variable que hacer referencia a una columna de una tabla
     * La primera letra debe ponerse en mayusculas
     * por ejemplo:findByFaction() para realizar una busqueda
     */

    /**
     * Función Personalizada que se encarga de verificar el logueo de un usuario
     */
    public function doLogin($name,$pass){
        //cargamos el EntityManeger y realizamos una busqueda por campo de agente_name
        //Ojo con findBy devuelve un array y no una línea
        $agente = $this->findOneBy(['agent_name'=>$name]);
        if(is_null($agente)||empty($agente)){
            return false;
        }else{
            //Comprobamos la contraseña para verificar que es o no correcta.
            return password_verify($pass,$agente->getPassword());
        }
    }

    /**
     * Función Personalizada que se encarga de realizar el registro en la BB.DD. si procede
     * Devuelve false, si el agente no se ha registrado.
     */
    public function doRegister($name,$pass,$fac){
        //cargamos el EntityManeger y realizamos una busqueda por campo de agente_name
        $agente = $this->findOneBy(['agent_name'=>$name]);
        if(is_null($agente)||empty($agente)){
            //echo "No existe ningún agente con ese nombre<br>";
            if($fac == 1){
                $faction = 'Resistance';
            }else {
                $faction = 'Enlightened';
            }
            $agent = new Agent();
            $agent->setAgent_name($name)
                ->setPassword(password_hash($pass,PASSWORD_BCRYPT))
                ->setFaction($faction);
            $this->getEntityManager()->persist($agent);
            $this->getEntityManager()->flush();
            //Tras el flush enviamos el id del agente para verificar que efectivamente se ha insertado en la BB.DD.
            return $agent->getId_agent();
        }else{
            //echo "Existen agentes con ese nombre<br>";
            return 0;
        }
    }

}