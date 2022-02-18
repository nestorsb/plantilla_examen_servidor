<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\EntityManager;
use App\Entity\Pedidos;
use App\Entity\Facturas;
use Doctrine\Common\Util\Debug;


class ListPedidosController extends AbstractController
{
    public function listPedidos(){

        $em = (new EntityManager())->get();
        $agentRepository = $em->getRepository(Pedidos::class);
        $todosPedidos = $agentRepository->findAll();

        // Debug::dump($todosPedidos[0]->getid());
    


        $this->render('listPedidos.html', [
            'pedidos' => $todosPedidos
        ]);
    }
}
