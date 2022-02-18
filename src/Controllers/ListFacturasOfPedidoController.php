<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\EntityManager;
use App\Entity\Pedidos;
use App\Entity\Facturas;
use Doctrine\Common\Util\Debug;


class ListFacturasOfPedidoController extends AbstractController
{
    public function listFacturasOfPedido($nombreEmpresa){

        $em = (new EntityManager())->get();
        $pedidosRepository = $em->getRepository(Pedidos::class);

        $facturasFiltradas = $pedidosRepository->findFacturasOfEmpresas($nombreEmpresa);

        $this->render('listFacturasOfPedido.html', [
            'facturas' => $facturasFiltradas
        ]);
    }
}
