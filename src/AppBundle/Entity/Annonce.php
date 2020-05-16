<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/**
 * Annonce
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AnnonceRepository")
 * @ORM\HasLifecycleCallbacks()

 */
class Annonce {

    const SERVER_PATH_TO_UPLOADED_ANOUNCE_IMAGE_FOLDER = 'uploads/images/annonces';
    const SERVER_PATH_TO_UPLOADED_ANOUNCE_PDF_FOLDER = 'uploads/pdfs/annonces';

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
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="annonceur", type="string", length=255)
     */
    private $annonceur;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255, unique=true)
     */
    private $contenu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="time", nullable=true)
     */
    private $updated;
    
    
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
     * @var int
     *
     * @ORM\Column(name="downloadCount", type="integer" )
     */
    private $downloadCount;

    /**
     * @var \bool
     *
     * @ORM\Column(name="visibilite", type="boolean")
     */
    private $visibilite = true;
    private $fields;

    /**
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="auteur_id", referencedColumnName="id", nullable=true)
     */
    private $auteur;
    
   /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Vote", mappedBy="annonce",cascade={"persist"})    
     * @ORM\JoinColumn(nullable=true)
     *    
     *   */
    private $votes;

    /**
     * Unmapped property to handle file uploads
     */
    private $file;

    /**
     * Unmapped property to handle file uploads
     */
    private $support;

    /**
     * @var string
     *
     * @ORM\Column(name="imageName", type="string", length=255)
     */
    protected $imageName;

    /**
     * @var string
     *
     * @ORM\Column(name="supportName", type="string", length=255, nullable=true)
     */
    protected $supportName;

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
     * Get file.
     *
     * @return UploadedFile
     */
    public function getSupport() {
        return $this->support;
    }
    
     /**
     * Sets file.
     *
     * @param UploadedFile $support
     */
    public function setSupport(UploadedFile $support = null) {
        $this->support = $support;
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

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Annonce
     */
    public function setTitre($titre) {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre() {
        return $this->titre;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     * @return Annonce
     */
    public function setContenu($contenu) {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string 
     */
    public function getContenu() {
        return $this->contenu;
    }

    /**
     * Set visibilite
     *
     * @param boolean $visibilite
     * @return Annonce
     */
    public function setVisibilite($visibilite) {
        $this->visibilite = $visibilite;

        return $this;
    }

    /**
     * Get visibilite
     *
     * @return boolean 
     */
    public function getVisibilite() {
        return $this->visibilite;
    }

    /**
     * Set auteur
     *
     * @param \Application\Sonata\UserBundle\Entity\User $auteur
     * @return Annonce
     */
    public function setAuteur(\Application\Sonata\UserBundle\Entity\User $auteur) {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return \Application\Sonata\UserBundle\Entity\User 
     */
    public function getAuteur() {
        return $this->auteur;
    }

    /**
     * Set annonceur
     *
     * @param string $annonceur
     * @return Annonce
     */
    public function setAnnonceur($annonceur) {
        $this->annonceur = $annonceur;

        return $this;
    }

    public function setImageName($imageName) {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get annonceur
     *
     * @return string 
     */
    public function getAnnonceur() {
        return $this->annonceur;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Annonce
     */
    public function setUpdated($updated) {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated() {
        return $this->updated;
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

    public function getAbsolutePath() {
        return null === $this->imageName ? null : $this->getUploadRootDir() . '/' . $this->imageName;
    }

    public function getAbsolutePathSupport() {
        return null === $this->supportName ? null : $this->getUploadRootDir() . '/' . $this->supportName;
    }

    public function getWebPath() {
        return null === $this->imageName ? null : $this->getUploadDir() . '/' . $this->imageName;
    }

    public function getWebPathSupport() {
        return null === $this->supportName ? null : $this->getUploadDir() . '/' . $this->supportName;
    }

    protected function getUploadRootDir($basepath = '') {
        // the absolute directory path where uploaded images should be saved
        return $basepath . $this->getUploadDir();
    }

    protected function getUploadRootDirSupport($basepath = '') {
        // the absolute directory path where uploaded pdfs should be saved
        return $basepath . $this->getUploadDirSupport();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return self::SERVER_PATH_TO_UPLOADED_ANOUNCE_IMAGE_FOLDER;
    }

    protected function getUploadDirSupport() {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return self::SERVER_PATH_TO_UPLOADED_ANOUNCE_PDF_FOLDER;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload($basepath) {
        // the file property can be empty if the field is not required
        if (null === $this->file) {
            return;
        }

        if (null === $basepath) {
            return;
        }
        
        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the target filename to move to
         $this->file->move(substr($this->getUploadRootDir($basepath),0), $this->file->getClientOriginalName());
       
        // set the path property to the filename where you'ved saved the file
        $this->setImageName($this->file->getClientOriginalName());
       

        // clean up the file property as you won't need it anymore
       
        $this->file = null;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function uploadSupport($basepath) {
        // the support property can be empty if the field is not required
        if (null === $this->support) {
            return;
        }

        if (null === $basepath) {
            return;
        }

        // we use the original support name here but you should
        // sanitize it at least to avoid any security issues
        // move takes the target directory and then the target supportname to move to
       
      
         $this->support->move(substr($this->getUploadRootDirSupport($basepath), 14), $this->support->getClientOriginalName());
        // set the path property to the supportname where you'ved saved the file
        $this->setSupportName($this->support->getClientOriginalName());
          
        // clean up the support property as you won't need it anymore
        $this->support = null;
       
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload() {
        $file = $this->getAbsolutePath();
        if ($file) {
            unlink($file);
        }
    }
     /**
     * @ORM\PostRemove()
     */
    public function removeUploadSupport() {
        $support = $this->getAbsolutePathSupport();
        if ($support) {
            unlink($support);
        }
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName() {
        return $this->imageName;
    }

    /**
     * Set supportName
     *
     * @param string $supportName
     *
     * @return Annonce
     */
    public function setSupportName($supportName) {
        $this->supportName = $supportName;

        return $this;
    }

    /**
     * Get supportName
     *
     * @return string
     */
    public function getSupportName() {
        return $this->supportName;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->votes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->likeCount=0;
        $this->dislikeCount=0;
        $this->downloadCount=0;
      
    }

  

    /**
     * Add vote
     *
     * @param \AppBundle\Entity\Vote $vote
     *
     * @return Annonce
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
     * Set likeCount
     *
     * @param integer $likeCount
     *
     * @return Annonce
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
     * @return Annonce
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
     * Set downloadCount
     *
     * @param integer $downloadCount
     *
     * @return Annonce
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
