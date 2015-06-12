<?php

namespace itoldyooBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * IToldyooReceiver
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class IToldyooReceiver
{
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
     * @ORM\Column(name="itoldyoo_id", type="integer")
     */
    private $itoldyoo_id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creation_date;

    /**
     * @var string
     *
     * @ORM\Column(name="receiver_email", type="string", length=255)
     */
    private $receiver_email;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="sent_date", type="datetime")
     */
    private $sent_date;
    /**
     * @ORM\ManyToOne(targetEntity="IToldyoo", inversedBy="receivers")
     * @ORM\JoinColumn(name="itoldyoo_id", referencedColumnName="id")
     **/
    private $itoldyoo;

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
     * Set itoldyoo_id
     *
     * @param integer $itoldyooId
     * @return IToldyooReceiver
     */
    public function setItoldyooId($itoldyooId)
    {
        $this->itoldyoo_id = $itoldyooId;

        return $this;
    }

    /**
     * Get itoldyoo_id
     *
     * @return integer 
     */
    public function getItoldyooId()
    {
        return $this->itoldyoo_id;
    }

    /**
     * Set creation_date
     *
     * @param \DateTime $creationDate
     * @return IToldyooReceiver
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
     * Set receiver_email
     *
     * @param string $receiverEmail
     * @return IToldyooReceiver
     */
    public function setReceiverEmail($receiverEmail)
    {
        $this->receiver_email = $receiverEmail;

        return $this;
    }

    /**
     * Get receiver_email
     *
     * @return string 
     */
    public function getReceiverEmail()
    {
        return $this->receiver_email;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return IToldyooReceiver
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
     * Set sent_date
     *
     * @param \DateTime $sentDate
     * @return IToldyooReceiver
     */
    public function setSentDate($sentDate)
    {
        $this->sent_date = $sentDate;

        return $this;
    }

    /**
     * Get sent_date
     *
     * @return \DateTime 
     */
    public function getSentDate()
    {
        return $this->sent_date;
    }

    /**
     * Gets the value of itoldyoo.
     *
     * @return mixed
     */
    public function getItoldyoo()
    {
        return $this->itoldyoo;
    }

    /**
     * Sets the value of itoldyoo.
     *
     * @param mixed $itoldyoo the itoldyoo
     *
     * @return self
     */
    public function setItoldyoo($itoldyoo)
    {
        $this->itoldyoo = $itoldyoo;

        return $this;
    }
}
