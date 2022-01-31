<?php
/**
 * Clase que modela la Tabla Events de la BB.DD. con Doctrine
 */
namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventsRepository::class)
 * @ORM\Table(name="events")
 */
class Events{
    
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_event", type="integer")
     */
    private $id_event;

    /**
     * @ORM\Column(name="name_event", type="string", unique="true", length=100)
     */
    private $name;

    /**
     * @ORM\Column(name="alias_event", type="string", length=100)
     */
    private $alias;
    
    /**
     * @ORM\Column(name="descrip_event", type="string", nullable="true", length=250)
     */
    private $descripcion;

    /**
     * @ORM\Column(name="date_event", type="date")
     */
    private $date;

    /**
     * @ORM\Column(name="place_event", type="string", length=250)
     */
    private $place;

    /**
     * Un Evento para muchos StatsEvents, Lado de uno, bidireccional
     * @ORM\OneToMany(targetEntity="StatsEvents", mappedBy="event")
     */
    private $statsEvents;

    /**
     * Mediante el constructor se inicializan los ArrayCollection de las asociaciones de 
     * uno a muchos que tenemos con la tabla agent
     */
    public function __construct(){
        //Inicializamos las variables asociadas como Arraycollection para poder
        // obtener todos los objetos asociados
        $this->statsEvents = new ArrayCollection();
    }
    
    /**
     * Get the value of id_event
     */ 
    public function getId_event()
    {
        return $this->id_event;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of alias
     */ 
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * Set the value of alias
     *
     * @return  self
     */ 
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
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
     * Get the value of place
     */ 
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set the value of place
     *
     * @return  self
     */ 
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get un Evento para muchos StatsEvents, Lado de uno, bidireccional
     */ 
    public function getStatEvents()
    {
        return $this->statsEvents;
    }

    /**
     * Set un Evento para muchos StatsEvents, Lado de uno, bidireccional
     * donde también hemos realizado la insercción en la tabla StatsEvents el objeto Event
     *
     * @return  self
     */ 
    public function setStatEvents(StatsEvents $statsEvents)
    {
        if(!$this->statsEvents->contains($statsEvents)){
            $this->statsEvents[] = $statsEvents;
            $statsEvents->setEvent($this);
        }

        return $this;
    }
}