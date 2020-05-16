<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emission
 * @ORM\Entity
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EnquiryRepository")
 */
class Enquiry {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

  
    // Cet emeuteur peut être connecté !
    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User",cascade={"persist"}) 
     * @ORM\JoinColumn(nullable=true) 
     */
    private $emetteur;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    // Si l'émetteur n'est pas connecté on récupère l'email par lequel il l'a envoyé
    private $emailEmetteur;
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    // Si l'émetteur n'est pas connecté on récupère le nom par lequel il l'a envoyé
    private $nameEmetteur;
    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="dateEnvoie", type="datetime", nullable=false)
     */
    private $dateEnvoie;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=false)
     */
    private $body;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    

    /**
     * Set body
     *
     * @param string $body
     * @return Enquiry
     */
    public function setBody($body) {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody() {
        return $this->body;
    }

  
    /**
     * Set subject
     *
     * @param string $subject
     * @return Enquiry
     */
    public function setSubject($subject) {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject() {
        return $this->subject;
    }

    /**
     * Set emetteur
     *
     * @param \Application\Sonata\UserBundle\Entity\User $emetteur
     *
     * @return Enquiry
     */
    public function setEmetteur(\Application\Sonata\UserBundle\Entity\User $emetteur = null) {
        $this->emetteur = $emetteur;

        return $this;
    }

    /**
     * Get emetteur
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getEmetteur() {
        return $this->emetteur;
    }


    /**
     * Set dateEnvoie
     *
     * @param \DateTime $dateEnvoie
     *
     * @return Enquiry
     */
    public function setDateEnvoie($dateEnvoie)
    {
        $this->dateEnvoie = $dateEnvoie;

        return $this;
    }

    /**
     * Get dateEnvoie
     *
     * @return \DateTime
     */
    public function getDateEnvoie()
    {
        return $this->dateEnvoie;
    }

    /**
     * Set emailEmetteur
     *
     * @param string $emailEmetteur
     *
     * @return Enquiry
     */
    public function setEmailEmetteur($emailEmetteur)
    {
        $this->emailEmetteur = $emailEmetteur;

        return $this;
    }

    /**
     * Get emailEmetteur
     *
     * @return string
     */
    public function getEmailEmetteur()
    {
        return $this->emailEmetteur;
    }

    /**
     * Set nameEmetteur
     *
     * @param string $nameEmetteur
     *
     * @return Enquiry
     */
    public function setNameEmetteur($nameEmetteur)
    {
        $this->nameEmetteur = $nameEmetteur;

        return $this;
    }

    /**
     * Get nameEmetteur
     *
     * @return string
     */
    public function getNameEmetteur()
    {
        return $this->nameEmetteur;
    }
}
