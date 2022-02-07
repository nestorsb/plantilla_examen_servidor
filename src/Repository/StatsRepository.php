<?php

/**
 * Clase que extiende del EntityRepository donde podemos personalizar los métodos
 * que creamos necesitar añadiendo a los ya definidos por defecto.
 */

namespace App\Repository;

use App\Entity\Stats;
use App\Core\EntityManager;
use App\Entity\Agent;
use App\Entity\Span;
use App\Entity\Uploads;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Id;

class StatsRepository extends EntityRepository
{
    /**
     * Funcion que devuelve los nombres de las columnas de la tabla stats en un array
     * @return array $columnames[]
     */
    public function getColumnNames()
    {
        $em = $this->getEntityManager();
        $schemaManager = $em->getConnection()->getSchemaManager();
        $columns = $schemaManager->listTableColumns('stats');
        $columnNames = [];
        foreach ($columns as $column) {
            $columnNames[] = $column->getName();
        }
        //Borramos los nombres de las cabeceras que no queremos mostrar en el html
        $columnNames = array_diff($columnNames, array('id_stats', 'id_upload', 'id_agent')); 
        return $columnNames;
    }

    /**
     * Funcion que recibe un array de las estadisticas y devuelve otro array de estadisticas 
     * en el que ha eliminado los registros del mismo Agente y ha dejado el registro del Agente con 
     * el ip_upload mas reciente. Sustituye a un Group By Agent_name seleccionando el id_upload mas reciente (mayor).  
     * @param stats Array(int,object) de Doctrine.
     * @return stats Array de estadisticas filtrado como se expresa en la descripción.
     */
    public function doGroupByInStats($stats){

        foreach ($stats as $stat) {
            $agent_name = $stat->getAgent()->getAgent_name();
            $upload_id = $stat->getId_upload()->getId_upload();

            $arrayInfo['Agent_name'] = 'Id_upload'; //creo el array para que no este vacio
            
            if (!array_key_exists($agent_name, $arrayInfo)) {
              $arrayInfo[$agent_name] = $upload_id;
            } elseif ($arrayInfo[$agent_name] < $upload_id) {
              $arrayInfo[$agent_name] = $upload_id;
            }
          }
      
          foreach($stats as $key=>$onestat){
            if($arrayInfo[$onestat->getAgent()->getAgent_name()] !== $onestat->getId_upload()->getId_upload())
                unset($stats[$key]);
          };

          return $stats;
    }


    //Aqui escribiremos nuestros métodos personalizados

    /**
     * Por defecto hemos extendido los métodos:
     * find, findBy, findOneBy y findAll
     */

    /**
     * También se pueden usar metodos como findBy****
     * donde **** es la variable que hacer referencia a una columna de una tabla
     * La primera letra debe ponerse en mayusculas
     * por ejemplo:findBySeer() para realizar una busqueda de una estadisticas
     */
}
