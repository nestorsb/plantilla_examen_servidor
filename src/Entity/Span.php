<?php

namespace App\Entity;

use App\Repository\SpanRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpanRepository::class)
 * @ORM\Table(name="span")
 */

class Span
{
    /**
     * @ORM\id 
     * @ORM\Column(type="integer", name="id_span")
     * @ORM\GeneratedValue
     * @ORM\OneToMany(targetEntity="Upload", mappedBy="span_time") */
    private $span_id;

    /** @ORM\Column(type="string", name="time_span") */
    private $span_time;

    /**
     * Get the value of span_id
     */ 
    public function getSpan_id()
    {
        return $this->span_id;
    }

    /**
     * Get the value of span_time
     */ 
    public function getSpan_time()
    {
        return $this->span_time;
    }

    //falta setter de Span_time, pero lo veo innecesario.
}

