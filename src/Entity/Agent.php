<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgentRepository::class)
 * @ORM\Table(name="agent")
 */

class Agent
{
    /**
     * @ORM\id 
     * @ORM\Column(type="integer", name="id_agent")
     * @ORM\GeneratedValue
     */
    private $agent_id;

    /** @ORM\Column(type="string", name="agent_name") */
    private $agent_name;

    /** @ORM\Column(type="string", name="`password`") */
    private $password;

    /** @ORM\Column(type="string", name="faction") */
    private $faction;

    /**
     * @ORM\OneToMany(targetEntity="Upload", mappedBy="agent")
     */
    private $uploads;

    /**
     * @ORM\OneToMany(targetEntity="Stats", mappedBy="stats_id")
     */    
    private $stats;

    /**
     * @ORM\OneToMany(targetEntity="StatsEvents", mappedBy="agent")
     */
    private $statsEvents;


    public function __construct()
    {
        $this->uploads = new ArrayCollection();
        $this->stats = new ArrayCollection();
        $this->statsEvents = new ArrayCollection();
    }
    /**
     * Get the value of agent_id
     */ 
    public function getAgent_id()
    {
        return $this->agent_id;
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
     * Get the value of uploads
     */ 
    public function getUploads()
    {
        return $this->uploads;
    }

    /**
     * Set the value of uploads
     *
     * @return  self
     */ 
    public function setUploads($uploads)
    {
        $this->uploads = $uploads;

        return $this;
    }

    /**
     * Get the value of stats
     */ 
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * Set the value of stats
     *
     * @return  self
     */ 
    public function setStats($stats)
    {
        $this->stats = $stats;

        return $this;
    }

    /**
     * Get the value of statsEvents
     */ 
    public function getStatsEvents()
    {
        return $this->statsEvents;
    }

    /**
     * Set the value of statsEvents
     *
     * @return  self
     */ 
    public function setStatsEvents($statsEvents)
    {
        $this->statsEvents = $statsEvents;

        return $this;
    }
    }
