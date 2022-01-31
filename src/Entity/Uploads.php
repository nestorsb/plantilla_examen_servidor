<?php
/**
 * Clase que modela la Tabla Uploads de la BB.DD. con Doctrine
 */
namespace App\Entity;

use App\Repository\UploadsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UploadsRepository::class)
 * @ORM\Table(name="uploads")
 */
class Uploads{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_upload", type="integer")
     */
    private $id_upload;

    /**
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\Column(name="time", type="time")
     */
    private $time;

    /**
     * Muchas subidas para un agente, Lado de Muchos inversedBy, bidireccional
     * @ORM\ManyToOne(targetEntity="Agent", inversedBy="uploads")
     * @ORM\JoinColumn(name="id_agent", referencedColumnName="id_agent")
     */
    private $agent;

    /**
     * Muchas subidas para un time spant, Lado de Muchos inversedBy, bidireccional
     * @ORM\ManyToOne(targetEntity="Span", inversedBy="uploads")
     * @ORM\JoinColumn(name="time_span", referencedColumnName="id_span")
     */
    private $span;

    /**
     * Establece true o false dependiendo de si la subida pertenece a un evento o no.
     * @ORM\Column(name="id_event", type="boolean")
     */
    private $event;

    /**
     * Una Subida por cada Stats, Lado de uno mappedBy, bidireccional
     * @ORM\OneToOne(targetEntity="Stats", mappedBy="id_upload")
     * @ORM\JoinColumn(name="id_upload", referencedColumnName="id_upload")
     */
    private $stat;

    /**
     * Una Subida por cada Stats_Event, Lado de uno mappedBy, bidireccional
     * @ORM\OneToOne(targetEntity="StatsEvents", mappedBy="upload")
     * @ORM\JoinColumn(name="id_upload", referencedColumnName="id_upload")
     */
    private $statEvent;

    /**
     * Get the value of id_upload
     */ 
    public function getId_upload()
    {
        return $this->id_upload;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of time
     */ 
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */ 
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get de muchos Uploads para un Agente, Lado de muchos inversedBy
     */ 
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set muchos uploads para un agente, Lado de Muchos inversedBy
     * Set de un agente para muchos Uploads, Lado de one mappedBy
     *
     * @return  self
     */ 
    public function setAgent($agent)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get muchas subidas para un time spant, Lado de Muchos inversedBy
     */ 
    public function getSpan()
    {
        return $this->span;
    }

    /**
     * Set muchas subidas para un time spant, Lado de Muchos inversedBy
     *
     * @return  self
     */ 
    public function setSpan($span)
    {
        $this->span = $span;

        return $this;
    }

    /**
     * Get establece true o false dependiendo de si la subida pertenece a un evento o no.
     */ 
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set establece true o false dependiendo de si la subida pertenece a un evento o no.
     *
     * @return  self
     */ 
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get una Subida por cada Stats, Lado de uno mappedBy, bidireccional
     */ 
    public function getStat()
    {
        return $this->stat;
    }

    /**
     * Set una Subida por cada Stats, Lado de uno mappedBy, bidireccional
     * Creamos además la insercción del objeto Stats asociadas a la subida
     * 
     * @return  self
     */ 
    public function setStat(Stats $stat)
    {
        if(!$this->stat == ($stat)){
            $this->stat = $stat;
            $stat->setId_upload($this);
        }

        return $this;
    }

    /**
     * Get una Subida por cada Stats_Event, Lado de uno mappedBy, bidireccional
     */ 
    public function getStatEvent()
    {
        return $this->statEvent;
    }

    /**
     * Set una Subida por cada Stats_Event, Lado de uno mappedBy, bidireccional
     * Creamos además la insercción del objeto Stats asociadas a la subida
     *
     * @return  self
     */ 
    public function setStatEvent(StatsEvents $statEvent)
    {
        if(!$this->statEvent == ($statEvent)){
            $this->statEvent = $statEvent;
            $statEvent->setUpload($this);
        }

        return $this;
    }
}