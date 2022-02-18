<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\EntityManager;
use App\Entity\Pedidos;
use Doctrine\Common\Util\Debug;


class InsertController extends AbstractController
{
    public function insert()
    {
        $em = (new EntityManager())->get();
        $pedidosRepository = $em->getRepository(Pedidos::class);

        $this->render('insert.html', []);

        if (isset($_POST["submit"])) {
            if ($pedidosRepository->insertData($_POST)) {
                echo "Guardado Correctamente";
            } else echo "Ha ocurrido un error con la inserción";
        }
    }
}
