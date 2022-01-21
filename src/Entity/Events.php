<?php

namespace App\Entity;

use App\Repository\EventsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EventsRepository::class)
 * @ORM\Table(name="events")
 */

class Events
{
    //prueba@ORM\OneToMany(targetEntity="StatsEvents", mappedBy="event_id")
    /** 
     * @ORM\id 
     * @ORM\Column(type="integer", name="id_event")
     * @ORM\GeneratedValue
     */
    private $event_id;

    /** @ORM\Column(type="string", name="name_event") */
    private $event_name;

    /** @ORM\Column(type="string", name="alias_event") */
    private $event_alias;

    /** @ORM\Column(type="string", name="descrip_event") */
    private $event_description;
    
    /** @ORM\Column(type="date", name="date_event") */
    private $event_date;

    /** @ORM\Column(type="string", name="place_event") */
    private $event_place;

    /** @ORM\OneToMany(targetEntity="StatsEvents", mappedBy="event") */
    private $StatsEvents;
}