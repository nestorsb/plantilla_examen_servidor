<?php
/**
 * Clase que modela la Tabla Stats_Events de la BB.DD. con Doctrine
 */
namespace App\Entity;

use App\Repository\StatsEventsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatsEventsRepository::class)
 * @ORM\Table(name="stats_events")
 */
class StatsEvents{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_stats", type="integer")
     */
    private $id_stats;

    /**
     * Muchas estadística para un evento, Lado de Muchos inversedBy, bidireccional
     * @ORM\ManyToOne(targetEntity="Events", inversedBy="statsEvents")
     * @ORM\JoinColumn(name="id_event", referencedColumnName="id_event")
     */
    private $event;

    /**
     * Una estadística para una upload, Lado inverso, bidireccional
     * @ORM\OneToOne(targetEntity="Uploads", inversedBy="statEvent")
     * @ORM\JoinColumn(name="id_upload", referencedColumnName="id_upload") 
     */
    private $upload;

    /**
     * Muchas estadística para una agente, Lado de Muchos inversedBy, bidireccional
     * @ORM\ManyToOne(targetEntity="Agent", inversedBy="statsEvents")
     * @ORM\JoinColumn(name="id_agent", referencedColumnName="id_agent")
     */
    private $agent;

    /**
     * @ORM\Column(name="lifetime_ap", type="integer")
     */
    private $lifetimeAP;

    /**
     * @ORM\Column(name="unique_portals_visited", type="integer", nullable="true")
     */
    private $uniquePortalsVisited;

    /**
     * @ORM\Column(name="resonators_deployed", type="integer", nullable="true")
     */
    private $resonatorsDeployed;

    /**
     * @ORM\Column(name="links_created", type="integer", nullable="true")
     */
    private $linksCreated;
    
    /**
     * @ORM\Column(name="control_fields_created", type="integer", nullable="true")
     */
    private $controlFields;

    /**
     * @ORM\Column(name="xm_recharged", type="integer", nullable="true")
     */
    private $xmRecharged;

    /**
     * @ORM\Column(name="portals_captured", type="integer", nullable="true")
     */
    private $portalsCaptured;

    /**
     * @ORM\Column(name="hacks", type="integer", nullable="true")
     */
    private $hacks;

    /**
     * @ORM\Column(name="resonators_destroyed", type="integer", nullable="true")
     */
    private $resonatorsDestroyed;

    /**
     * Get the value of id_stats
     */ 
    public function getId_stats()
    {
        return $this->id_stats;
    }

    /**
     * Get muchas subidas para un evento, Lado de Muchos inversedBy
     */ 
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set muchas subidas para un evento, Lado de Muchos inversedBy
     *
     * @return  self
     */ 
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get una estadística para una upload, Lado inverso
     */ 
    public function getUpload()
    {
        return $this->upload;
    }

    /**
     * Set una estadística para una upload, Lado inverso
     *
     * @return  self
     */ 
    public function setUpload($upload)
    {
        $this->upload = $upload;

        return $this;
    }

    /**
     * Get muchas estadística para una agente, Lado de Muchos inversedBy
     */ 
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set muchas estadística para una agente, Lado de Muchos inversedBy
     *
     * @return  self
     */ 
    public function setAgent($agent)
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * Get the value of lifetimeAP
     */ 
    public function getLifetimeAP()
    {
        return $this->lifetimeAP;
    }

    /**
     * Set the value of lifetimeAP
     *
     * @return  self
     */ 
    public function setLifetimeAP($lifetimeAP)
    {
        $this->lifetimeAP = $lifetimeAP;

        return $this;
    }

    /**
     * Get the value of uniquePortalsVisited
     */ 
    public function getUniquePortalsVisited()
    {
        return $this->uniquePortalsVisited;
    }

    /**
     * Set the value of uniquePortalsVisited
     *
     * @return  self
     */ 
    public function setUniquePortalsVisited($uniquePortalsVisited)
    {
        $this->uniquePortalsVisited = $uniquePortalsVisited;

        return $this;
    }

    /**
     * Get the value of resonatorsDeployed
     */ 
    public function getResonatorsDeployed()
    {
        return $this->resonatorsDeployed;
    }

    /**
     * Set the value of resonatorsDeployed
     *
     * @return  self
     */ 
    public function setResonatorsDeployed($resonatorsDeployed)
    {
        $this->resonatorsDeployed = $resonatorsDeployed;

        return $this;
    }

    /**
     * Get the value of linksCreated
     */ 
    public function getLinksCreated()
    {
        return $this->linksCreated;
    }

    /**
     * Set the value of linksCreated
     *
     * @return  self
     */ 
    public function setLinksCreated($linksCreated)
    {
        $this->linksCreated = $linksCreated;

        return $this;
    }

    /**
     * Get the value of controlFields
     */ 
    public function getControlFields()
    {
        return $this->controlFields;
    }

    /**
     * Set the value of controlFields
     *
     * @return  self
     */ 
    public function setControlFields($controlFields)
    {
        $this->controlFields = $controlFields;

        return $this;
    }

    /**
     * Get the value of xmRecharged
     */ 
    public function getXmRecharged()
    {
        return $this->xmRecharged;
    }

    /**
     * Set the value of xmRecharged
     *
     * @return  self
     */ 
    public function setXmRecharged($xmRecharged)
    {
        $this->xmRecharged = $xmRecharged;

        return $this;
    }

    /**
     * Get the value of portalsCaptured
     */ 
    public function getPortalsCaptured()
    {
        return $this->portalsCaptured;
    }

    /**
     * Set the value of portalsCaptured
     *
     * @return  self
     */ 
    public function setPortalsCaptured($portalsCaptured)
    {
        $this->portalsCaptured = $portalsCaptured;

        return $this;
    }

    /**
     * Get the value of hacks
     */ 
    public function getHacks()
    {
        return $this->hacks;
    }

    /**
     * Set the value of hacks
     *
     * @return  self
     */ 
    public function setHacks($hacks)
    {
        $this->hacks = $hacks;

        return $this;
    }

    /**
     * Get the value of resonatorsDestroyed
     */ 
    public function getResonatorsDestroyed()
    {
        return $this->resonatorsDestroyed;
    }

    /**
     * Set the value of resonatorsDestroyed
     *
     * @return  self
     */ 
    public function setResonatorsDestroyed($resonatorsDestroyed)
    {
        $this->resonatorsDestroyed = $resonatorsDestroyed;

        return $this;
    }
}