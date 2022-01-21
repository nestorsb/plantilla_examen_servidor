<?php

namespace App\Entity;

use App\Repository\UploadsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UploadsRepository::class)
 * @ORM\Table(name="uploads")
 */

class Upload
{
    /**
     * @ORM\id 
     * @ORM\Column(type="integer", name="id_upload")
     * @ORM\GeneratedValue
     * @ORM\OneToOne(targetEntity="Stats")
     * @ORM\JoinColumn(name="id_upload", referencedColumnName="upload")
     * @ORM\OneToOne(targetEntity="StatsEvents")
     */
    private $upload_id;

    /** @ORM\Column(type="date", name="date") */
    private $date;

    /** @ORM\Column(type="time", name="time") */
    private $time;

    /** @ORM\ManyToOne(targetEntity="Agent", inversedBy="uploads") 
    */
    private $agent;
    
    /** @ORM\ManyToOne(targetEntity="Span", inversedBy="span_id") */
    private $span_time;

    /** @ORM\Column(type="integer", name="id_event") */
    private $id_event;
}

