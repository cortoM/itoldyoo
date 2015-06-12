<?php

namespace itoldyooBundle\Business\DTO;

use itoldyooBundle\Business\DTO\DefaultDTO;

class IToldyooDTO {

	private $description;
	private $creationDate;
	private $scheduledDate;
	private $status;

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
     * Gets the value of creationDate.
     *
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Sets the value of creationDate.
     *
     * @param mixed $creationDate the creation date
     *
     * @return self
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

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
     * Gets the value of status.
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the value of status.
     *
     * @param mixed $status the status
     *
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}

