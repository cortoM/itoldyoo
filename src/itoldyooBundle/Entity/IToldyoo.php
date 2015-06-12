<?php

namespace itoldyooBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * IToldyoo
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class IToldyoo
{
    public function __construct()
    {
        $this->receivers = new ArrayCollection();
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $user_id;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=2000)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="sender_email", type="string", length=255)
     */
    private $sender_email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creation_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="process_date", type="datetime")
     */
    private $process_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_update_date", type="datetime")
     */
    private $last_update_date;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="scheduled_date", type="datetime")
     */
    private $scheduled_date;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="technical_description", type="string", length=255)
     */
    private $technical_description;

    /**
     * @ORM\OneToMany(targetEntity="IToldyooReceiver" , mappedBy="itoldyoo", cascade={"all"})
     *  
     **/
    private $receivers;

    /**
     * @var string
     *
     * @ORM\Column(name="ip_address", type="string", length=30)
     */
    private $ipAddress;

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
     * Set user_id
     *
     * @param integer $userId
     * @return IToldyoo
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return IToldyoo
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set sender_email
     *
     * @param string $senderEmail
     * @return IToldyoo
     */
    public function setSenderEmail($senderEmail)
    {
        $this->sender_email = $senderEmail;

        return $this;
    }

    /**
     * Get sender_email
     *
     * @return string 
     */
    public function getSenderEmail()
    {
        return $this->sender_email;
    }

    /**
     * Set creation_date
     *
     * @param \DateTime $creationDate
     * @return IToldyoo
     */
    public function setCreationDate($creationDate)
    {
        $this->creation_date = $creationDate;

        return $this;
    }

    /**
     * Get creation_date
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * Set process_date
     *
     * @param \DateTime $processDate
     * @return IToldyoo
     */
    public function setProcessDate($processDate)
    {
        $this->process_date = $processDate;

        return $this;
    }

    /**
     * Get process_date
     *
     * @return \DateTime 
     */
    public function getProcessDate()
    {
        return $this->process_date;
    }

    /**
     * Set last_update_date
     *
     * @param \DateTime $lastUpdateDate
     * @return IToldyoo
     */
    public function setLastUpdateDate($lastUpdateDate)
    {
        $this->last_update_date = $lastUpdateDate;

        return $this;
    }

    /**
     * Get last_update_date
     *
     * @return \DateTime 
     */
    public function getLastUpdateDate()
    {
        return $this->last_update_date;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return IToldyoo
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set technical_description
     *
     * @param string $technicalDescription
     * @return IToldyoo
     */
    public function setTechnicalDescription($technicalDescription)
    {
        $this->technical_description = $technicalDescription;

        return $this;
    }

    /**
     * Get technical_description
     *
     * @return string 
     */
    public function getTechnicalDescription()
    {
        return $this->technical_description;
    }
    public function addReceiver(IToldyooReceiver $iToldyooReceiver){
        $iToldyooReceiver->setIToldyoo($this);
        $this->receivers->add($iToldyooReceiver);
    }

    /**
     * Gets the value of scheduled_date.
     *
     * @return \DateTime
     */
    public function getScheduledDate()
    {
        return $this->scheduled_date;
    }

    /**
     * Sets the value of scheduled_date.
     *
     * @param \DateTime $scheduled_date the scheduled date
     *
     * @return self
     */
    public function setScheduledDate(\DateTime $scheduled_date)
    {
        $this->scheduled_date = $scheduled_date;

        return $this;
    }

    /**
     * Gets the value of ipAddress.
     *
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Sets the value of ipAddress.
     *
     * @param mixed $ipAddress the ip address
     *
     * @return self
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }
}
