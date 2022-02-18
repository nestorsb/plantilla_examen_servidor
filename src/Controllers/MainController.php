<?php

namespace App\Controllers;

use App\Core\AbstractController;
use App\Core\EntityManager;
use App\Entity\Pedidos;
use App\Entity\Facturas;
use Doctrine\Common\Util\Debug;


class MainController extends AbstractController
{
    public function main(){
        $this->render('main.html', []);
    }
}
