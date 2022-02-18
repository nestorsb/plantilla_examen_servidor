<?php
/**
 * Clase que modela la Tabla Agent de la BB.DD. con Doctrine
 */
Namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgentRepository::class)
 * @ORM\Table(name="agent")
 */
class Agent{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_agent", type="integer")
     */
    private $id_agent;

    /**
     * @ORM\Column(name="agent_name", type="string", unique="true", length=100)
     */
    private $agent_name;

    /**
     * Un agente para muchos Uploads, Lado de Uno, bidireccional
     * @ORM\OneToMany(targetEntity="Uploads", mappedBy="agent")
     */
    private $uploads;

    public function __construct(){

        $this->uploads = new ArrayCollection();

    }

    /**
     * Get the value of id_agent
     */ 
    public function getId_agent()
    {
        return $this->id_agent;
    }

    /**
     * Get the value of agent_name
     */ 
    public function getAgent_name()
    {
        return $this->agent_name;
    }

    /**
     * Set the value of agent_name
     *
     * @return  self
     */ 
    public function setAgent_name($agent_name)
    {
        $this->agent_name = $agent_name;

        return $this;
    }

    /**
     * Get de un agente para muchos Uploads, Lado de one mappedBy
     */ 
    public function getUploads()
    {
        return $this->uploads;
    }

    /**
     * Set de un agente para muchos Uploads, Lado de one mappedBy
     * donde también hemos realizado la insercción en la tabla Uploads el objeto Agente
     *
     * @return  self
     */ 
    public function setUploads(Uploads $uploads)
    {
        if(!$this->uploads->contains($uploads)){
            $this->uploads[] = $uploads;
            $uploads->setAgent($this);
        }

        return $this;
    }
}