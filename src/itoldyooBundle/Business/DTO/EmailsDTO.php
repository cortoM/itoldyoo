<?php

namespace itoldyooBundle\Business\DTO;

use itoldyooBundle\Business\DTO\DefaultDTO;

class EmailsDTO extends DefaultDTO{

	private $emails;

	public function __construct($code) {
         parent::__construct($code);
        $this->emails = array();
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

    public function addEmail($email){
    	array_push($this->emails, $email);
    }
}