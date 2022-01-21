<?php

namespace App\Entity;

use App\Repository\StatsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatsRepository::class)
 * @ORM\Table(name="stats")
 */

class Stats
{
    /**
     * @ORM\id 
     * @ORM\Column(type="integer", name="id_upload")
     * @ORM\GeneratedValue
     */
    private $stats_id;

    /** @ORM\OneToOne(targetEntity="Uploads", mappedBy="upload_id") */
    private $upload;

    /** @ORM\ManyToOne(targetEntity="Agent", inversedBy="agent_id") */
    private $agent;

    /** @ORM\Column(type="integer", name="level") */
    private $level;

    /** @ORM\Column(type="integer", name="lifetime_ap") */
    private $lifetine_ap;

    /** @ORM\Column(type="integer", name="current_ap") */
    private $current_ap;

    /** @ORM\Column(type="integer", name="`mission_day(s)_attended`") */
    private $mission_days_attended;

    /** @ORM\Column(type="integer", name="`nl-1331_meetup(s)_attended`") */
    private $meetups_attended;

}

