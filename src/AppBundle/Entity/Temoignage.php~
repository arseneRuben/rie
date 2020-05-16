<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Temoignage
 *
 * @ORM\Table(name="temoignage")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TemoignageRepository")
 */
class Temoignage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

   
    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="auditeur_id", referencedColumnName="id", nullable=true)
     */
    private $auditeur;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vote", mappedBy="temoignage",cascade={"persist"})    
     * @ORM\JoinColumn(nullable=true)
     *    
     *   */
    private $votes;
    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="text")
     */
    private $contenu;
   /**
     * @var \bool
     *
     * @ORM\Column(name="visibilite", type="boolean")
     */
    private $visibilite = true;

    /**
     * @var int
     *
     * @ORM\Column(name="likecount", type="integer", )
     */
    private $likeCount;
    
     /**
     * @var int
     *
     * @ORM\Column(name="dislikecount", type="integer", )
     */
    private $dislikeCount;
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
     /**
     * Constructor
     */
    public function __construct()
    {       
         $this->votes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->likeCount=0;
        $this->dislikeCount=0;
    }

    /**
     * Set auditeur
     *
     * @param string $auditeur
     *
     * @return Temoignage
     */
    public function setAuditeur($auditeur)
    {
        $this->auditeur = $auditeur;

        return $this;
    }


    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Temoignage
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Set visibilite
     *
     * @param boolean $visibilite
     *
     * @return Temoignage
     */
    public function setVisibilite($visibilite)
    {
        $this->visibilite = $visibilite;

        return $this;
    }

    /**
     * Get visibilite
     *
     * @return boolean
     */
    public function getVisibilite()
    {
        return $this->visibilite;
    }

    /**
     * Get auditeur
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getAuditeur()
    {
        return $this->auditeur;
    }

    /**
     * Set likeCount
     *
     * @param integer $likeCount
     *
     * @return Temoignage
     */
    public function setLikeCount($likeCount)
    {
        $this->likeCount = $likeCount;

        return $this;
    }

    /**
     * Get likeCount
     *
     * @return integer
     */
    public function getLikeCount()
    {
        return $this->likeCount;
    }

    /**
     * Set dislikeCount
     *
     * @param integer $dislikeCount
     *
     * @return Temoignage
     */
    public function setDislikeCount($dislikeCount)
    {
        $this->dislikeCount = $dislikeCount;

        return $this;
    }

    /**
     * Get dislikeCount
     *
     * @return integer
     */
    public function getDislikeCount()
    {
        return $this->dislikeCount;
    }

    /**
     * Add vote
     *
     * @param \AppBundle\Entity\Vote $vote
     *
     * @return Temoignage
     */
    public function addVote(\AppBundle\Entity\Vote $vote)
    {
        $this->votes[] = $vote;

        return $this;
    }

    /**
     * Remove vote
     *
     * @param \AppBundle\Entity\Vote $vote
     */
    public function removeVote(\AppBundle\Entity\Vote $vote)
    {
        $this->votes->removeElement($vote);
    }

    /**
     * Get votes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVotes()
    {
        return $this->votes;
    }
}
