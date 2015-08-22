<?php

namespace itoldyooBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use itoldyooBundle\Entity\User;
use itoldyooBundle\Entity\UserEmail;
use itoldyooBundle\Entity\Repository\UserRepository;
use itoldyooBundle\Business\Common\ResponseCode;

class HelloController extends Controller
{
	public function indexAction($name)
	{

	
		return $this->render('itoldyooBundle:Hello:index.html.twig', 
			array('name' => 'name', 'trad' => 't', 'service' => 'getName'));
	}

}