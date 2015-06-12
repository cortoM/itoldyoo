<?php

namespace itoldyooBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('itoldyooBundle:Default:index.html.twig', array());
    }
}
