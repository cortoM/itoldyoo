<?php

namespace itoldyooBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ComponentController extends Controller
{
	public function getTemplateAction($componentName)
	{
		return $this->render('itoldyooBundle:Components:'.$componentName.'.html.twig', array());
	}
}