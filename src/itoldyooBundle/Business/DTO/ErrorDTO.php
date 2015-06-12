<?php

namespace itoldyooBundle\Business\DTO;

use itoldyooBundle\Business\DTO\DefaultDTO;

class ErrorDTO extends DefaultDTO{

	private $message;

	public function __construct($message, $code) {
        parent::__construct($code);
        $this->message = $message;
	}

    /**
     * Gets the value of message.
     *
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets the value of message.
     *
     * @param mixed $message the message
     *
     * @return self
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }
}
