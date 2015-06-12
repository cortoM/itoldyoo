<?php

namespace itoldyooBundle\Business\DTO;

use itoldyooBundle\Business\DTO\DefaultDTO;
use itoldyooBundle\Business\DTO\IToldyooDTO;

class IToldyooListDTO extends DefaultDTO{  

	private $content;// = new array();

	public function __construct() {
        $this->content = array();
    }


    /**
     * Gets the value of content.
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets the value of content.
     *
     * @param mixed $content the content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    public function addItoldyooDTO(IToldyooDTO $itoldyooDTO){
    	array_push($this->content, $itoldyooDTO);
    }
}