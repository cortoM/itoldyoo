<?php

namespace itoldyooBundle\Business\DTO;

use itoldyooBundle\Business\DTO\DefaultDTO;

class NewIToldyooCTO {

	private $description;
	private $scheduledDate;
	private $email;
	private $emails;

	public function __construct() {
        $this->emails = array();
    }

    /**
     * Gets the value of description.
     *
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the value of description.
     *
     * @param mixed $description the description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Gets the value of scheduledDate.
     *
     * @return mixed
     */
    public function getScheduledDate()
    {
        return $this->scheduledDate;
    }

    /**
     * Sets the value of scheduledDate.
     *
     * @param mixed $scheduledDate the scheduled date
     *
     * @return self
     */
    public function setScheduledDate($scheduledDate)
    {
        $this->scheduledDate = $scheduledDate;

        return $this;
    }

    /**
     * Gets the value of email.
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the value of email.
     *
     * @param mixed $email the email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Gets the value of emails.
     *
     * @return mixed
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * Sets the value of emails.
     *
     * @param mixed $emails the emails
     *
     * @return self
     */
    public function setEmails($emails)
    {
        $this->emails = $emails;

        return $this;
    }

    public function isValid(){
        if (empty($this->description)) return false;
    
        $tmpDate = new \DateTime($this->scheduledDate);
        $tmpNow = new \DateTime("now");
        if ($tmpDate <= $tmpNow) return false;
 
        if ( !preg_match( "/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}/", $this->email ) ) return false;
        foreach ($this->emails as $email){
            if ( !preg_match("/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+\.[a-zA-Z]{2,4}/", $email ) ) return false;
        }
        return true;
    }
}
