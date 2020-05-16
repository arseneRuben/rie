<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Emission
 * @ORM\Entity
 * @ORM\Table(name="emission")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EmissionRepository")
 * @UniqueEntity("nom", message="Cette emission existe déjà !")
 * @ORM\HasLifecycleCallbacks()
 */
class Emission {

    const SERVER_PATH_TO_UPLOADED_EMISSION_IMAGE_FOLDER = 'uploads/images/emissions';
     const SERVER_PATH_TO_UPLOADED_PASSAGE_MEDIA_FOLDER = 'uploads/media';
    

    
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Espace", mappedBy="emission",cascade={"persist"},orphanRemoval=true)
     * @ORM\JoinColumn(nullable=false)
     */
    private $espaces;

  
   
    /**
     * @var string
     *
     * @ORM\Column(name="imagename", type="string", length=255)
     */
    protected $imageName;
    protected $file;

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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=true)
     */
    private $nomdefichier;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="interactif", type="boolean")
     */
    private $interactif;

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

    public function getAbsolutePath() {
        return null === $this->imageName ? null : $this->getUploadRootDir() . '/' . $this->imageName;
    }

    public function getWebPath() {
        return null === $this->imageName ? null : $this->getUploadDir() . '/' . $this->imageName;
    }

    protected function getUploadRootDir($basepath) {
        // the absolute directory path where uploaded documents should be saved
        return $basepath . $this->getUploadDir();
    }

    protected function getUploadDir() {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return self::SERVER_PATH_TO_UPLOADED_EMISSION_IMAGE_FOLDER;
    }

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
        $this->file->move(substr($this->getUploadRootDir($basepath), 0), $this->file->getClientOriginalName());

        // set the path property to the filename where you'ved saved the file
        $this->setImageName($this->file->getClientOriginalName());
      
        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    /**
     * Lifecycle callback to upload the file to the server
     */
    public function lifecycleFileUpload() {
        $this->upload();
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
     * Set description
     *
     * @param string $description
     * @return Emission
     */
    public function setDescription($description) {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set d�but
     *
     * @param \DateTime $debut
     * @return Emission
     */
    public function setDebut($debut) {
        $this->debut = $debut;

        return $this;
    }

    /**
     * Get debut
     *
     * @return \DateTime 
     */
    public function getDebut() {
        return $this->debut;
    }

    /**
     * Set interactif
     *
     * @param boolean $interactif
     * @return Emission
     */
    public function setInteractif($interactif) {
        $this->interactif = $interactif;

        return $this;
    }

    /**
     * Get interactif
     *
     * @return boolean 
     */
    public function getInteractif() {
        return $this->interactif;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Emission
     */
    public function setNom($nom) {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom() {
        return $this->nom;
    }

  
    public function __toString() {
        $nom = ( is_null($this->getNom())) ? "" : $this->getNom();
        return (string) ($nom );
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->passages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->espaces = new \Doctrine\Common\Collections\ArrayCollection();
       
        
    }

  
    /**
     * Set espaces
     *
     * @param \AppBundle\Entity\Espace $espaces
     * @return Emission
     */
    public function setEspaces($espaces) {
        if (count($espaces) > 0) {
            foreach ($espaces as $i) {
                $this->addEspace($i);
            }
        }

        return $this;
    }

    /**
     * Add espaces
     *
     * @param \AppBundle\Entity\Espace $espaces
     * @return Emission
     */
    public function addEspace(\AppBundle\Entity\Espace $espace) {
        //$this->espaces[] = $espace;
        $espace->setEmission($this);
        $this->espaces->add($espace);

        return $this;
    }

    /**
     * Remove espaces
     *
     * @param \AppBundle\Entity\Espace $espace
     */
    public function removeEspace(\AppBundle\Entity\Espace $espace) {
        $this->espaces->removeElement($espace);
    }

    /**
     * Get espaces
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEspaces() {
        return $this->espaces;
    }

    /**
     * Set nomdefichier
     *
     * @param string $nomdefichier
     * @return Emission
     */
    public function setNomdefichier($nomdefichier) {
        $this->nomdefichier = $nomdefichier;

        return $this;
    }

    /**
     * Get nomdefichier
     *
     * @return string 
     */
    public function getNomdefichier() {
        return $this->nomdefichier;
    }

    
    /**
     * Set imageName
     *
     * @param string $imageName
     *
     * @return Emission
     */
    public function setImageName($imageName) {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string
     */
    public function getImageName() {
        return $this->imageName;
    }

}
