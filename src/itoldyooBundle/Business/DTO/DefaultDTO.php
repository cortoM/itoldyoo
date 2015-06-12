<?php

namespace itoldyooBundle\Business\DTO;

class DefaultDTO {

	private $code;

	public function __construct($code) {
        $this->code = $code;
    }
    /**
     * Gets the value of code.
     *
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets the value of code.
     *
     * @param mixed $code the code
     *
     * @return self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }
}