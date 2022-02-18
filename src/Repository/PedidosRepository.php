<?php


namespace App\Repository;

use App\Core\EntityManager;
use App\Entity\Facturas;
use App\Entity\Pedidos;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\Mapping\Id;

class PedidosRepository extends EntityRepository
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


    public function insertData($arrayData)
    {

        $factura = new Facturas();
        $pedido = new Pedidos();

        //tipo
        if ($arrayData['tipo'] == 'venta') {
            $factura->settipo('FV');
            $pedido->settipo('PV');
        } else if ($arrayData['tipo'] == 'compra') {
            $factura->settipo('FC');
            $pedido->settipo('PC');
        }

        //empresa
        $pedido->setempresa($arrayData['empresa']);
        //producto
        $pedido->setproducto($arrayData['producto']);
        //precio
        $pedido->setprecio($arrayData['precio']);
        $factura->setvalor($arrayData['precio']);
        //fecha
        $pedido->setfecha(new \DateTime($arrayData['fecha']));
        $factura->setdate(new \DateTime($arrayData['fecha']));

        //INSERCION
        $this->getEntityManager()->persist($pedido);
        $factura->setpedido($pedido);
        $this->getEntityManager()->persist($factura);
        $this->getEntityManager()->flush();

        $ids = ['pedido' => $pedido->getid(), 'factura' => $factura->getid_factura()];

        echo "ID Pedido: ".$ids['pedido'];
        echo "<br>";
        echo "ID Factura: ".$ids['factura'];
        echo "<br>";
        return $ids;
    }


    public function findFacturasOfEmpresas($nombreEmpresa)
    {

        $pedidosOfEmpresa = $this->findBy(
            ['empresa' => $nombreEmpresa]
        );

        // Debug::dump($pedidosOfEmpresa);
        // echo '<br><br><br>';
        // Debug::dump($pedidosOfEmpresa[0]->getfacturas());

        $arrayFacturas = [];
        for ($i=0; $i < count($pedidosOfEmpresa); $i++) { 
            for ($j=0; $j < count($pedidosOfEmpresa[$i]->getfacturas()); $j++) { 
               array_push($arrayFacturas, $pedidosOfEmpresa[$i]->getfacturas()[$j]);
            }
        }
        return $arrayFacturas;
    }

    public function deletePedidoById($id){
        $pedido = $this->findOneBy(['id'=>$id]);
        $facturasRelacionadas = $pedido->getfacturas();

        //borramos las facturas relacionadas con el pedido
        for ($i=0; $i < count($facturasRelacionadas); $i++) { 
            $this->getEntityManager()->remove($facturasRelacionadas[$i]);
        }

        //borramos el pedido
        $this->getEntityManager()->remove($pedido);

        //actualizamos en base de datos
        $this->getEntityManager()->flush();

        header('location: /listPedidos');
    }


    //GETTERS Y SETTERS

    /**
     * Get variable que almacena los errores en un array de la siguiente forma:
     */
    public function getError_type()
    {
        return $this->error_type;
    }
}
