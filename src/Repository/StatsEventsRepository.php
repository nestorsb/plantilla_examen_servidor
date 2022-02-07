<?php
/**
 * Clase que extiende del EntityRepository donde podemos personalizar los métodos
 * que creamos necesitar añadiendo a los ya definidos por defecto.
 */
namespace App\Repository;

use App\Entity\StatsEvents;
use App\Core\EntityManager;
use Doctrine\ORM\EntityRepository;

class StatsEventsRepository extends EntityRepository{
    //Aqui escribiremos nuestros métodos personalizados

    /**
     * Por defecto hemos extendido los métodos:
     * find, findBy, findOneBy y findAll
     */

    /**
     * También se pueden usar metodos como findBy****
     * donde **** es la variable que hacer referencia a una columna de una tabla
     * La primera letra debe ponerse en mayusculas
     * por ejemplo:findByLifetimeAP() para realizar una busqueda de una estadisticas
     */


    /**
     * Funcion que recibe un array de las estadisticas de eventos y devuelve otro array de estadisticas 
     * en el que ha eliminado los registros del mismo Agente repetidos y ha dejado el registro del Agente con 
     * el ip_upload mas reciente. Sustituye a un Group By Agent_name seleccionando el id_upload mas reciente (mayor).  
     * @param stats Array(int,object) de Doctrine.
     * @return stats Array de estadisticas de eventos filtrado como se expresa en la descripción.
     */
    public function doGroupByInStatsEvents($stats){

        foreach ($stats as $stat) {
            $agent_name = $stat->getAgent()->getAgent_name();
            $upload_id = $stat->getUpload()->getId_upload();

            $arrayInfo['Agent_name'] = 'Id_upload'; //creo el array para que no este vacio
            
            if (!array_key_exists($agent_name, $arrayInfo)) {
              $arrayInfo[$agent_name] = $upload_id;
            } elseif ($arrayInfo[$agent_name] < $upload_id) {
              $arrayInfo[$agent_name] = $upload_id;
            }
          }
      
          foreach($stats as $key=>$onestat){
            if($arrayInfo[$onestat->getAgent()->getAgent_name()] !== $onestat->getUpload()->getId_upload())
                unset($stats[$key]);
          };

          return $stats;
    }

}