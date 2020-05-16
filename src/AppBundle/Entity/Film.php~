<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Film
 *
 * @ORM\Table(name="film")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FilmRepository")
 */
class Film
{
	 
        /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User",cascade={"persist"}) 
     * @ORM\JoinColumn(nullable=true) 
     */
    private $journalist;

    /**
     * @var string
     *
     * @ORM\Column(name="keywords", type="text")
     * @ORM\JoinColumn(nullable=true) 
     */
    private $keywords;

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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;
       /**
     * @var \Datetime
     *
     * @ORM\Column(name="datedujour", type="datetime")
     */
    private $dateDujour;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, unique=true)
     */
    private $path;
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;
     /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Film",inversedBy="films")
     * @ORM\JoinColumn(name="category", referencedColumnName="id", nullable=true)
     */
    private $category;


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
     * Set dateDujour
     *
     * @param \DateTime $dateDujour
     * @return Passage
     */
    public function setDateDujour($dateDujour) {
        $this->dateDujour = $dateDujour;

        return $this;
    }

    /**
     * Get dateDujour
     *
     * @return \DateTime 
     */
    public function getDateDujour() {
        return $this->dateDujour;
    }
    
  

  

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Film $category
     *
     * @return Film
     */
    public function setCategory(\AppBundle\Entity\Film $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Film
     */
    public function getCategory()
    {
        return $this->category;
    }
     /**
     * Set journalist
     *
     * @param \Application\Sonata\UserBundle\Entity\User $journalist
     * @return Passage
     */
    public function setJournalist(\Application\Sonata\UserBundle\Entity\User $journalist = null) {
        $this->journalist = $journalist;

        return $this;
    }

    /**
     * Get journalist
     *
     * @return \Application\Sonata\UserBundle\Entity\User
     */
    public function getJournalist() {
        return $this->journalist;
    }

     /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateDujour = new \Datetime();
	   $this->url = "";
    }


   

    /**
     * Set keywords
     *
     * @param string $keywords
     *
     * @return Film
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Film
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Film
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Film
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
