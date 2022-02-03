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
