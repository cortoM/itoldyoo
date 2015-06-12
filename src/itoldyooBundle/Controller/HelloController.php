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

		$userService = $this->get('user_service');

		/*$user = new User();
		$user->setName('George');
		$user->setSurname('billy');
		$user->setType(12);
		$user->setCreationDate(new \DateTime("now"));
		$user->setToken($this->gen_uuid());
		$email = new UserEmail();
		$email->setEmail("toto@tt.fr");
		$email->setCreationDate(new \DateTime("now"));
		$email->setOrigin("AA");
		$user->addEmail($email);
		$userService->createUser($user);*/
		//$em = $this->getDoctrine()->getManager();
		//$em->getRepository('itoldyooBundle:User')->createUser($user);
		$user = $userService->getUser($name);


		$auth = $this->get('auth_service');
		$t = $this->get('translator')->trans('global.application.name');
		$token = $this->gen_uuid();
		
		return $this->render('itoldyooBundle:Hello:index.html.twig', 
			array('name' => $name, 'trad' => $t, 'service' => $user->getName() ));
	}

	public function gen_uuid() {
	    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
	        // 32 bits for "time_low"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

	        // 16 bits for "time_mid"
	        mt_rand( 0, 0xffff ),

	        // 16 bits for "time_hi_and_version",
	        // four most significant bits holds version number 4
	        mt_rand( 0, 0x0fff ) | 0x4000,

	        // 16 bits, 8 bits for "clk_seq_hi_res",
	        // 8 bits for "clk_seq_low",
	        // two most significant bits holds zero and one for variant DCE1.1
	        mt_rand( 0, 0x3fff ) | 0x8000,

	        // 48 bits for "node"
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	    );
	}
}