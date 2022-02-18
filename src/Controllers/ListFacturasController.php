<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\EntityManager;
use App\Entity\Pedidos;
use App\Entity\Facturas;
use Doctrine\Common\Util\Debug;


class ListFacturasController extends AbstractController
{
    public function listFacturas(){

        $em = (new EntityManager())->get();
        $facturaRepository = $em->getRepository(Facturas::class);
        $todasFacturas = $facturaRepository->findAll();

        // Debug::dump($todosPedidos[0]->getid());
    


        $this->render('listFacturas.html', [
            'facturas' => $todasFacturas
        ]);
    }
}