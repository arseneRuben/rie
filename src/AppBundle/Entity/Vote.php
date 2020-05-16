<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vote
 *
 * @ORM\Table(name="vote")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VoteRepository")
 */
class Vote {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="auteur_id", referencedColumnName="id", nullable=true)
     */
    private $auteur;
      /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Annonce")
     * @ORM\JoinColumn(name="annonce_id", referencedColumnName="id", nullable=true)
     */
    private $annonce;
       /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Passage")
     * @ORM\JoinColumn(name="passage_id", referencedColumnName="id", nullable=true)
     */
    private $passage;
       /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Temoignage")
     * @ORM\JoinColumn(name="temoignage_id", referencedColumnName="id", nullable=true)
     */
    private $temoignage;
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return Vote
     */
    public function setValue($value) {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue() {
        return $this->value;
    }


    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Vote
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set auteur
     *
     * @param \Application\Sonata\UserBundle\Entity\User $auteur
     *
     * @return Vote
     */
    public function setAuteur(\Application\Sonata\UserBundle\Entity\User $auteur = null)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set annonce
     *
     * @param \AppBundle\Entity\Annonce $annonce
     *
     * @return Vote
     */
    public function setAnnonce(\AppBundle\Entity\Annonce $annonce = null)
    {
        $this->annonce = $annonce;

        return $this;
    }

    /**
     * Get annonce
     *
     * @return \AppBundle\Entity\Annonce
     */
    public function getAnnonce()
    {
        return $this->annonce;
    }

    /**
     * Set passage
     *
     * @param \AppBundle\Entity\Passage $passage
     *
     * @return Vote
     */
    public function setPassage(\AppBundle\Entity\Passage $passage = null)
    {
        $this->passage = $passage;

        return $this;
    }

    /**
     * Get passage
     *
     * @return \AppBundle\Entity\Passage
     */
    public function getPassage()
    {
        return $this->passage;
    }

    /**
     * Set temoignage
     *
     * @param \AppBundle\Entity\Temoignage $temoignage
     *
     * @return Vote
     */
    public function setTemoignage(\AppBundle\Entity\Temoignage $temoignage = null)
    {
        $this->temoignage = $temoignage;

        return $this;
    }

    /**
     * Get temoignage
     *
     * @return \AppBundle\Entity\Temoignage
     */
    public function getTemoignage()
    {
        return $this->temoignage;
    }
}
