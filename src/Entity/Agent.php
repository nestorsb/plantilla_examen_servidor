<?php
/**
 * Clase que modela la Tabla Agent de la BB.DD. con Doctrine
 */
namespace App\Entity;

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
     * @ORM\Column(name="agent_name", type="string", unique="true", lenght="100")
     */
    private $agent_name;

    /**
     * @ORM\Column(name="`password`", type="string", lenght="64")
     */
    private $password;

    /**
     * @ORM\Column(name="faction", type="string", lenght="100")
     */
    private $faction;

    /**
     * Un agente para muchos Uploads, Lado de Uno, bidireccional
     * @ORM\OneToMany(targetEntity="Uploads", mappedBy="agent")
     */
    private $uploads;

    /**
     * Un agente para muchas Estadísticas, Lado de Uno, bidireccional
     * @ORM\OneToMany(targetEntity="Stats", mappedBy="agent")
     */
    private $stats;

    /**
     * Un agente para muchas Estadísticas de Eventos, Lado de Uno, bidireccional
     * @ORM\OneToMany(targetEntity="StatsEvents", mappedBy="agent")
     */
    private $statsEvents;

    /**
     * Mediante el constructor se inicializan los ArrayCollection de las asociaciones de 
     * uno a muchos que tenemos con la tabla agent
     */
    public function __construct(){
        //Inicializamos las variables asociadas como Arraycollection para poder
        // obtener todos los objetos asociados
        $this->uploads = new ArrayCollection();
        $this->stats = new ArrayCollection();
        $this->statsEvents = new ArrayCollection();
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
     * Get the value of password
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */ 
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of faction
     */ 
    public function getFaction()
    {
        return $this->faction;
    }

    /**
     * Set the value of faction
     *
     * @return  self
     */ 
    public function setFaction($faction)
    {
        $this->faction = $faction;

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

    /**
     * Get de un agente para muchas Estadísticas de Eventos, Lado de one Mapped
     */ 
    public function getStatsEvents()
    {
        return $this->statsEvents;
    }

    /**
     * Set de un agente para muchas Estadísticas de Eventos, Lado de one Mapped
     * donde también hemos realizado la insercción en la tabla StatsEvents el objeto Agente
     *
     * @return  self
     */ 
    public function setStatsEvents(StatsEvents $statsEvents)
    {
        if(!$this->statsEvents->contains($statsEvents)){
            $this->statsEvents[] = $statsEvents;
            $statsEvents->setAgent($this);
        }

        return $this;
    }

    /**
     * Get un agente para muchas Estadísticas, Lado de one Mapped
     */ 
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * Set un agente para muchas Estadísticas, Lado de one Mapped
     * donde también hemos realizado la insercción en la tabla Stats el objeto Agente
     *
     * @return  self
     */ 
    public function setStats(Stats $stats)
    {
        if(!$this->stats->contains($stats)){
            $this->stats[] = $stats;
            $stats->setAgent($this);
        }

        return $this;
    }
}