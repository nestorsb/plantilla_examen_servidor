<?php

/**
 * Clase que modela la Tabla Facturas de la BB.DD. con Doctrine
 */

namespace App\Entity;

use App\Repository\FacturasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacturasRepository::class)
 * @ORM\Table(name="facturas")
 */
class Facturas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_factura", type="integer")
     */
    private $id_factura;

    /**
     * @ORM\Column(name="tipo", type="string", nullable="true", length=2)
     */
    private $tipo;

    /**
     * @ORM\Column(name="valor", type="decimal")
     */
    private $valor;

    /**
     * @ORM\Column(name="fecha", type="date")
     */
    private $date;

    /**
     * Muchas facturas para un pedido, Lado de Muchos inversedBy, bidireccional
     * @ORM\ManyToOne(targetEntity="Pedidos", inversedBy="facturas")
     * @ORM\JoinColumn(name="id_pedido", referencedColumnName="id")
     */
    private $pedido;

    public function __construct()
    {

        // $this->pedido = new ArrayCollection();

    }

    /**
     * Get the value of id_agent
     */
    public function getid_factura()
    {
        return $this->id_factura;
    }

    /**
     * Get the value of agent_name
     */
    public function gettipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of agent_name
     *
     * @return  self
     */
    public function settipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }
    /**
     * Get the value of agent_name
     */
    public function getvalor()
    {
        return $this->valor;
    }

    /**
     * Set the value of agent_name
     *
     * @return  self
     */
    public function setvalor($valor)
    {
        $this->valor = $valor;

        return $this;
    }
    /**
     * Get the value of agent_name
     */
    public function getdate()
    {
        return $this->date;
    }

    /**
     * Set the value of agent_name
     *
     * @return  self
     */
    public function setdate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get de un agente para muchos Uploads, Lado de one mappedBy
     */
    public function getpedido()
    {
        return $this->pedidos;
    }

    /**
     * Set de un agente para muchos Uploads, Lado de one mappedBy
     * donde también hemos realizado la insercción en la tabla Uploads el objeto Agente
     *
     * @return  self
     */
    public function setpedido($pedido)
    {
        $this->pedido = $pedido;
        return $this;
    }
}
