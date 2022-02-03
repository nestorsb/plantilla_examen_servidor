<?php
/**
 * Clase que modela la Tabla Span de la BB.DD. con Doctrine
 */
namespace App\Entity;

use App\Repository\SpanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpanRepository::class)
 * @ORM\Table(name="span")
 */
class Span{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id_span", type="integer")
     */
    private $id_span;

    /**
     * @ORM\Column(name="time_span", type="string", unique="true", length="100")
     */
    private $time_span;

    /**
     * Una espacio de tiempo para muchos Uploads, Lado de one mappedBy, bidireccional
     * @ORM\OneToMany(targetEntity="Uploads", mappedBy="span")
     */
    private $uploads;

    /**
     * Mediante el constructor se inicializan los ArrayCollection de las asociaciones de 
     * uno a muchos que tenemos con la tabla span
     */
    public function __construct(){
        //Inicializamos la variable asociada como Arraycollection para poder
        //obtener todos los objetos asociados
        $this->uploads = new ArrayCollection;
    }

    /**
     * Get the value of id_span
     */ 
    public function getId_span()
    {
        return $this->id_span;
    }

    /**
     * Get the value of time_span
     */ 
    public function getTime_span()
    {
        return $this->time_span;
    }

    /**
     * Set the value of time_span
     *
     * @return  self
     */ 
    public function setTime_span($time_span)
    {
        $this->time_span = $time_span;

        return $this;
    }

    /**
     * Get un espacio de tiempo para muchos Uploads, Lado de one mappedBy
     */ 
    public function getUploads()
    {
        return $this->uploads;
    }

    /**
     * Set un espacio de tiempo para muchos Uploads, Lado de one mappedBy
     * donde también hemos realizado la insercción en la tabla Uploads el objeto span
     *
     * @return  self
     */ 
    public function setUploads(Uploads $uploads)
    {
        if(!$this->uploads->contains($uploads)){
            $this->uploads[] = $uploads;
            $uploads->setSpan($this);
        }

        return $this;
    }
}