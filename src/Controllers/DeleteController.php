<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\EntityManager;
use App\Entity\Pedidos;



class DeleteController extends AbstractController
{
  public function delete($id)
  {
    $em = (new EntityManager())->get();
    $pedidosRepository = $em->getRepository(Pedidos::class);

    $pedidosRepository->deletePedidoById($id);
  }
}
