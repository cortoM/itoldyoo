<?php

namespace itoldyooBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IToldyooController extends Controller
{
	public function indexAction()
	{
		return $this->render('itoldyooBundle:IToldyoo:home.html.twig', array());
	}
}