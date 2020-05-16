<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 *  EmissionPassageJournalist
 * @ORM\Table(name="passage")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PassageRepository")
 */
class Passage {
     const SERVER_PATH_TO_UPLOADED_PASSAGE_MEDIA_FOLDER = 'uploads/media';
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Espace")
     * @ORM\JoinColumn(nullable=true)
     */
    private $espace;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="datedujour", type="datetime")
     */
    private $dateDujour;

   

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Emission", inversedBy="passages")
     * @ORM\JoinColumn(nullable=true)
     */
    private $emission;

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
     * @var int
     *
     * @ORM\Column(name="likecount", type="integer" )
     */
    private $likeCount;
    
    /**
     * @var int
     *
     * @ORM\Column(name="downloadCount", type="integer" )
     */
    private $downloadCount;
    
     /**
     * @var int
     *
     * @ORM\Column(name="dislikecount", type="integer" )
     */
    private $dislikeCount;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vote", mappedBy="annonce",cascade={"persist"})    
     * @ORM\JoinColumn(nullable=true)
     *    
     *   */
    private $votes;
    
     private $fields;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }
    /**
     * Set fields
     *
     * @param string $fields
     * @return Annonce
     */
    public function setFields($fields) {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Get fields
     *
     * @return string 
     */
    public function getFields() {
        return $this->fields;
    }

    /**
     * Set emission
     *
     * @param \AppBundle\Entity\Emission $emission
     * @return Passage
     */
    public function setEmission(\AppBundle\Entity\Emission $emission = null) {
        $this->emission = $emission;

        return $this;
    }

    /**
     * Get emission
     *
     * @return \AppBundle\Entity\Emission 
     */
    public function getEmission() {
        return $this->emission;
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

    public function __toString() {

        $emission = ( is_null($this->getEmission())) ? "" : $this->getEmission();
        $journalist = ( is_null($this->getJournalist())) ? "" : $this->getJournalist();
        $date = ( is_null($this->getDateDujour())) ? "" : $this->getDateDujour();
         $keywords = ( is_null($this->getKeywords())) ? "" : $this->getKeywords();
        
        return (string) ($emission . "__" . $journalist. "__" . $keywords);
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
     * Set espace
     *
     * @param AppBundle\Entity\Espace $espace
     * @return Passage
     */
    public function setEspace(\AppBundle\Entity\Espace $espace = null) {
        $this->espace = $espace;

        return $this;
    }

    /**
     * Get espace
     *
     * @return \AppBundle\Entity\Espace
     */
    public function getEspace() {
        return $this->espace;
    }

    public function __construct() {

        $this->dateDujour = new \Datetime();
        $this->setLikeCount(0);
        $this->setDislikeCount(0);
         $this->downloadCount=0;
    }

    /**
     * Set appreciation
     *
     * @param string $appreciation
     * @return Passage
     */
    public function setAppreciation($appreciation) {
        $this->appreciation = $appreciation;

        return $this;
    }

    /**
     * Get appreciation
     *
     * @return string 
     */
    public function getAppreciation() {
        return $this->appreciation;
    }

    /**
    * @Assert\File(maxSize="10147483648")
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="mediaName", type="string", length=255)
     */
    protected $mediaName;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="time", nullable=true)
     */
    private $updated;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null) {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * Lifecycle callback to upload the file to the server
     */
    public function lifecycleFileUpload() {
        $this->upload();
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate() {
        $this->setUpdated(new \Datetime());
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated() {
        $this->setUpdated(new \DateTime());
    }

     public function getAbsolutePath() {
        return null === $this->getMediaName() ? null : $this->getUploadRootDir() . '/' . $this->getMediaName();
    }

    public function getWebPath() {
        return null === $this->getMediaName() ? null : $this->getUploadDir() . '/' . $this->getMediaName();
    }

    protected function getUploadRootDir($basepath) {
        // the absolute directory path where uploaded documents should be saved
        return $basepath . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return self::SERVER_PATH_TO_UPLOADED_PASSAGE_MEDIA_FOLDER.'/'.$this->getEmission()->getNom();
    }

    public function upload($basepath) {
        // the file property can be empty if the field is not required
        if (null === $this->file) {
            return;
        }

        if (null === $basepath) {
            return;
        }
        
        
        if (!file_exists(self::SERVER_PATH_TO_UPLOADED_PASSAGE_MEDIA_FOLDER.'/'.$this->getEmission()->getNom())) {
            mkdir(self::SERVER_PATH_TO_UPLOADED_PASSAGE_MEDIA_FOLDER.'/'.$this->getEmission()->getNom(), 0777, true);
           
            
        }
        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the target filename to move to
	   
        $this->file->move(substr($this->getUploadRootDir($basepath), 0), $this->file->getClientOriginalName());

        // set the path property to the filename where you'ved saved the file
        $this->setMediaName($this->file->getClientOriginalName());

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }


  

    /**
     * Set mediaName
     *
     * @param string $mediaName
     *
     * @return Passage
     */
    public function setMediaName($mediaName)
    {
        $this->mediaName = $mediaName;

        return $this;
    }

    /**
     * Get mediaName
     *
     * @return string
     */
    public function getMediaName()
    {
        return $this->mediaName;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Passage
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set likeCount
     *
     * @param integer $likeCount
     *
     * @return Passage
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
     * @return Passage
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
     * @return Passage
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

    /**
     * Set keywords
     *
     * @param string $keywords
     *
     * @return Passage
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
     * Set downloadCount
     *
     * @param integer $downloadCount
     *
     * @return Passage
     */
    public function setDownloadCount($downloadCount)
    {
        $this->downloadCount = $downloadCount;

        return $this;
    }

    /**
     * Get downloadCount
     *
     * @return integer
     */
    public function getDownloadCount()
    {
        return $this->downloadCount;
    }
}
