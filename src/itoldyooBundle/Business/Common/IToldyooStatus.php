<?php

namespace itoldyooBundle\Business\Common;

class IToldyooStatus
{
    const TODO = 1;
    const SENT = 2;
    const ERROR = 3;
    const CANCELED = 4;

    public static function getTextKey($const){
    	switch($const){
    		case IToldyooStatus::TODO:
    			return "code.itoldyoo-status.done";
    		case IToldyooStatus::SENT:
    			return "code.itoldyoo-status.sent";
    		case IToldyooStatus::ERROR:
    			return "code.itoldyoo-status.error";
    		case IToldyooStatus::CANCELED:
    			return "code.itoldyoo-status.canceled";    			    			    		
    	}
    }
    
}


