<?php

namespace App\Entity;

use App\Repository\StatsEventsRepository;
use BadFunctionCallException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatsEventsRepository::class)
 * @ORM\Table(name="stats_events")
 */

class StatsEvents
{
    /**
     * @ORM\id 
     * @ORM\Column(type="integer", name="id_upload")
     * @ORM\GeneratedValue */
    private $statsEvents_id;

    /** @ORM\ManyToOne(targetEntity="Events", inversedBy="StatsEvents")*/
    private $event;

    /** @ORM\OneToOne(targetEntity="Uploads") 
     * @ORM\JoinColumn(name="id_upload", referencedColumnName="id_upload")
     * */
    private $upload;

    /** @ORM\ManyToOne(targetEntity="Agent", inversedBy="StatsEvents") */
    private $agent;
    
    /** @ORM\Column(type="integer", name="lifetime_ap") */
    private $lifetime_ap;
    
    /** @ORM\Column(type="integer", name="resonators_deployed") */
    private $resonators_deployed;
        
    /** @ORM\Column(type="integer", name="unique_portals_visited") */
    private $unique_portals_visited;

    /** @ORM\Column(type="integer", name="control_fields_created") */
    private $control_fields_created;

    /** @ORM\Column(type="integer", name="xm_recharched") */
    private $xm_recharched;

    /** @ORM\Column(type="integer", name="links_created") */
    private $links_created;

    /** @ORM\Column(type="integer", name="portals_captured") */
    private $portals_captured;

    /** @ORM\Column(type="integer", name="hacks") */
    private $hacks;

    /** @ORM\Column(type="integer", name="resonators_destroyed") */
    private $resonators_destroyed;

    public function __construct()
    {
        $this->event = new ArrayCollection();
    }

}

