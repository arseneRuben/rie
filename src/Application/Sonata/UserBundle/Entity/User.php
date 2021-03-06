<?php

namespace Application\Sonata\UserBundle\Entity;

use Symfony\Component\Security\Core\Util\SecureRandom;
use Symfony\Component\Validator\Constraints as Assert;
use Sonata\UserBundle\Entity\BaseUser as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * User
 * @ORM\Entity(repositoryClass="Application\Sonata\UserBundle\Repository\UserRepository")
 * @ORM\Table(name="utilisateur")

 * @ORM\HasLifecycleCallbacks
 */
class User extends BaseUser {

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Passage", mappedBy="journalist",cascade={"persist"})    
     * @ORM\JoinColumn(nullable=true)
     *    
     * */
    private $passages;
    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Film", mappedBy="journalist",cascade={"persist"})    
     * @ORM\JoinColumn(nullable=true)
     *    
     * */
    private $sermons;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Assert\File(
     *     maxSize = "5M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/tiff"},
     *     maxSizeMessage = "The maxmimum allowed file size is 5MB.",
     *     mimeTypesMessage = "Only the filetypes image are allowed.")
     */
    protected $avatar;
     
    /**
     * Date/Time of the last activity
     *
     * @var \Datetime
     * @ORM\Column(name = "lastactivityat", type = "datetime")
     */
    protected $lastActivityAt;

   
    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    protected $facebook_access_token;
   

    /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
    protected $google_access_token;
   
    
    

//////////////////////////////////////////////
////////////Setters & Getters/////////////////
//////////////////////////////////////////////

    public function __construct() {
        parent::__construct();
        $this->passages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sermons = new \Doctrine\Common\Collections\ArrayCollection();

        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }
     /**
     * @param string $facebookUid
     *
     * @return User
     */
    public function setFacebookUid($facebookUid)
    {
        $this->facebookUid = $facebookUid;

        return $this;
    }

    /**
     * @return string
     */
    public function getFacebookUid()
    {
        return $this->facebookUid;
    }
     /**
     * @param string $gplusUid
     *
     * @return User
     */
    public function setGplusUid($gplusUid)
    {
        $this->gplusUid = $gplusUid;

        return $this;
    }

    /**
     * @return string
     */
    public function getGplusUid()
    {
        return $this->gplusUid;
    }

    public function setEmail($email) {
        if (!empty($email))
            $this->email = $email;

        return $this;
    }

    public function setUsername($username) {
        if (!empty($username))
            $this->username = $username;

        return $this;
    }

    /**
     * Set lockedTime
     *
     * @param \DateTime $lockedTime
     *
     * @return User
     */
    public function setLockedTime($lockedTime) {
        $this->locked_time = $lockedTime;

        return $this;
    }

    /**
     * Get lockedTime
     *
     * @return \DateTime
     */
    public function getLockedTime() {
        return $this->locked_time;
    }
    
    /**
     * Get id
     *
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Asks whether the user is granted a particular role
     * 
     * @return boolean
     */
    public function isGranted($role) {
        return in_array($role, $this->getRoles());
    }

    /**
     * Set lockedMessage
     *
     * @param string $lockedMessage
     *
     * @return User
     */
    public function setLockedMessage($lockedMessage = null) {
        $this->locked_message = $lockedMessage;

        return $this;
    }

    /**
     * Get lockedMessage
     *
     * @return string
     */
    public function getLockedMessage() {
        return $this->locked_message;
    }

    /**
     * Set lastActivity
     *
     * @param \Datetime $lastActivity
     * @return User
     */
    public function setlastActivityAt($lastActivity) {
        $this->lastActivityAt = $lastActivity;

        return $this;
    }

    /**
     * Get lastActivity
     *
     * @return \DateTime
     */
    public function getlastActivityAt() {
        return $this->lastActivityAt;
    }

    /**
     * @return Bool Whether the user is active or not
     */
    public function isActiveNow() {
// Delay during wich the user will be considered as still active
        $delay = new \DateTime('2 minutes ago');

        return ( $this->getLastActivityAt() > $delay );
    }

    /**
     * Set userIP
     *
     * @param array $userIP
     *
     * @return User
     */
    public function setUserIP($userIP) {
        if (count($this->userIP) >= 10) {
            for ($i = 0; $i <= 8; $i++)
                $this->userIP[$i] = $this->userIP[$i + 1];
            $this->userIP[9] = implode(",", $userIP);
        } else
            $this->userIP[] = implode($userIP);

        return $this;
    }

    /**
     * Get userIP
     *
     * @return array
     */
    public function getUserIP() {
        return $this->userIP;
    }

    public function getAvatar() {
        return $this->avatar;
    }

    public function __toString() {
        $username = ( is_null($this->getUserName())) ? "" : $this->getUserName();
        return $username;
    }
   
    /**
     * Set google_access_token
     *
     * @param string $googleAccessToken
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken) {
        $this->facebook_access_token = $facebookAccessToken;
        return $this;
    }

    /**
     * Get google_access_token
     *
     * @return string 
     */
    public function getFacebookAccessToken() {
        return $this->facebook_access_token;
    }
    
    /**
     * Set google_access_token
     *
     * @param string $googleAccessToken
     * @return User
     */
    public function setGoogleAccessToken($googleAccessToken) {
        $this->google_access_token = $googleAccessToken;
        return $this;
    }

    /**
     * Get google_access_token
     *
     * @return string 
     */
    public function getGoogleAccessToken() {
        return $this->google_access_token;
    }

    /**
     * Set registered_at
     *
     * @param \DateTime $registeredAt
     * @return User
     */
    public function setRegisteredAt($registeredAt) {
        $this->registered_at = $registeredAt;

        return $this;
    }

    /**
     * Add passages
     *
     * @param AppBundle\Entity\Passage $passages
     * @return User
     */
    public function addPassage(\AppBundle\Entity\Passage $passages) {
        $this->passages[] = $passages;

        return $this;
    }

    /**
     * Remove passages
     * @param \AppBundle\Entity\Passage $passages
     */
    public function removePassage(\AppBundle\Entity\Passage $passages) {
        $this->passages->removeElement($passages);
    }

    /**
     * Get passages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPassages() {
        return $this->passages;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload() {
        
    }

    /**
     * Called after entity persistence
     *
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload() {
// The file property can be empty if the field is not required
        if (null === $this->avatar) {
            return;
        }

// check if we have an old image
        if (isset($this->avatarTemp)) {
// delete the old image
            unlink($this->avatarTemp);
// clear the temp image path
            $this->avatarTemp = null;
        }

        $this->getAvatar()->move(
                $this->getUploadRootDir(), $this->avatarPath
        );

// Clean up the file property as you won't need it anymore
        $this->avatar = null;
    }

    /**
     * Sets avatar.
     *
     * @param Uploaded Avatar $avatar
     */
    public function setAvatar(UploadedFile $avatar = null) {
        $this->avatar = $avatar;
// check if we have an old image path
        if (isset($this->avatarPath)) {
// store the old name to delete after the update
            $this->avatarTemp = $this->avatarPath;
            $this->avatarPath = null;
        } else {
            $this->avatarPath = 'initial';
        }
    }

    public function getAbsolutePath() {
        return null === $this->avatarPath ? null : $this->getUploadRootDir() . '/' . $this->avatarPath;
    }

    public function getWebPath() {
        return null === $this->avatarPath ? null : $this->getUploadDir() . '/' . $this->avatarPath;
    }

    public function getUploadDir() {
        return 'img/uploads/avatars';
    }

    protected function getUploadRootDir() {
// On retourne le chemin relatif vers l'image pour notre code PHP
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
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

    public function getFull() {
        return $this->surname . " " . $this->name;
    }

}
