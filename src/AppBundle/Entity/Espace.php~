<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Passage
 
 * @ORM\Table(name="espace")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EspaceRepository")
 */
class Espace
{
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Passage", mappedBy="espace",cascade={"persist"},orphanRemoval=true)
     * @ORM\JoinColumn(nullable=true)
     */
    private $passages;
    
     /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Emission", inversedBy="espaces")
     * @ORM\JoinColumn(nullable=true)
     */
    private $emission;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="journee", type="string", length=15, unique=false)
     */
    private $journee;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debut", type="time")
     */
    private $debut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="time")
     */
    private $fin;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set journee
     *
     * @param string $journee
     * @return Passage
     */
    public function setJournee($journee)
    {
        $this->journee = $journee;

        return $this;
    }

    /**
     * Get journee
     *
     * @return string 
     */
    public function getJournee()
    {
        return $this->journee;
    }

    /**
     * Set debut
     *
     * @param \DateTime $debut
     * @return Passage
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;

        return $this;
    }

    /**
     * Get debut
     *
     * @return \DateTime 
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     * @return Passage
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime 
     */
    public function getFin()
    {
        return $this->fin;
    }

    /**
     * Set emission
     *
     * @param \AppBundle\Entity\Emission $emission
     * @return Passage
     */
    public function setEmission(\AppBundle\Entity\Emission $emission = null)
    {
        $this->emission = $emission;

        return $this;
    }

    /**
     * Get emission
     *
     * @return \AppBundle\Entity\Emission 
     */
    public function getEmission()
    {
        return $this->emission;
    }
    
     
     public function __toString() {
        
           $resultDebut =( is_null($this->getDebut()))? "":date_format($this->getDebut(), "H:i");
            $resultFin =( is_null($this->getFin()))? "":date_format($this->getFin(), "H:i");
          
        return  (string)( $this->getJournee().":".$resultDebut . "--". $resultFin);
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->passages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add passage
     *
     * @param \AppBundle\Entity\Passage $passage
     *
     * @return Espace
     */
    public function addPassage(\AppBundle\Entity\Passage $passage)
    {
        $this->passages[] = $passage;

        return $this;
    }

    /**
     * Remove passage
     *
     * @param \AppBundle\Entity\Passage $passage
     */
    public function removePassage(\AppBundle\Entity\Passage $passage)
    {
        $this->passages->removeElement($passage);
    }

    /**
     * Get passages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPassages()
    {
        return $this->passages;
    }
}
