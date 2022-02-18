<?php

namespace App\Repository;

use App\Core\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Util\Debug;



class FacturasRepository extends EntityRepository
{
    /**
     * Variable que almacena los errores en un array de la siguiente forma:
     * 1 - Tipo de error (numero)
     * 2 - Mensaje de error
     */
    private $error_type = array(
        'type' => null,
        'msg' => null
    );




    //GETTERS Y SETTERS

    /**
     * Get variable que almacena los errores en un array de la siguiente forma:
     */
    public function getError_type()
    {
        return $this->error_type;
    }
}

    
