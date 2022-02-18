<?php

/**
 * Clase que modela la Tabla Pedidos de la BB.DD. con Doctrine
 */

namespace App\Entity;

use App\Repository\PedidosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PedidosRepository::class)
 * @ORM\Table(name="pedidosfacturas")
 */
class Pedidos
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="tipo", type="string", length=2)
     */
    private $tipo;

    /**
     * @ORM\Column(name="fecha", type="date")
     */
    private $fecha;
    /**
     * @ORM\Column(name="empresa", type="string", length=100)
     */
    private $empresa;
    /**
     * @ORM\Column(name="producto", type="string", length=10)
     */
    private $producto;

    /**
     * @ORM\Column(name="precio", type="decimal")
     */
    private $precio;

    /**
     * Un pedido para muchas facturas, Lado de Uno, bidireccional
     * @ORM\OneToMany(targetEntity="facturas", mappedBy="pedido")
     */
    private $facturas;


    public function __construct(){

        $this->facturas = new ArrayCollection();

    }


    /**
     * Get the value of id_upload
     */
    public function getid()
    {
        return $this->id;
    }

    /**
     * Get the value of date
     */
    public function gettipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */
    public function settipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of time
     */
    public function getfecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */
    public function setfecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get de muchos Uploads para un Agente, Lado de muchos inversedBy
     */
    public function getempresa()
    {
        return $this->empresa;
    }

    /**
     * Set muchos uploads para un agente, Lado de Muchos inversedBy
     * Set de un agente para muchos Uploads, Lado de one mappedBy
     *
     * @return  self
     */
    public function setempresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get muchas subidas para un time spant, Lado de Muchos inversedBy
     */
    public function getproducto()
    {
        return $this->producto;
    }

    /**
     * Set muchas subidas para un time spant, Lado de Muchos inversedBy
     *
     * @return  self
     */
    public function setproducto($producto)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get establece true o false dependiendo de si la subida pertenece a un evento o no.
     */
    public function getprecio()
    {
        return $this->precio;
    }

    /**
     * Set establece true o false dependiendo de si la subida pertenece a un evento o no.
     *
     * @return  self
     */
    public function setprecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get una Subida por cada Stats, Lado de uno mappedBy, bidireccional
     */
    public function getfacturas()
    {
        return $this->facturas;
    }

    /**
     * Set una Subida por cada Stats, Lado de uno mappedBy, bidireccional
     * Creamos además la insercción del objeto Stats asociadas a la subida
     * 
     * @return  self
     */
    public function setfacturas(Facturas $facturas)
    {
        if (!$this->facturas == ($facturas)) {
            $this->facturas = $facturas;
            $facturas->setpedido($this);
        }

        return $this;
    }

}
