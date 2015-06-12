<?php

namespace itoldyooBundle\Business\Common;

abstract class IToldyooReceiverStatus
{
    const TODO = 1;
    const SENT = 2;
    const ERROR = 3;
    const CANCELED = 4;
    
}