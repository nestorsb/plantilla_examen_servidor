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
}