<?php

namespace itoldyooBundle\Business\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use itoldyooBundle\Business\Common\CookieName;
use itoldyooBundle\Entity\User;
use Symfony\Component\HttpFoundation\Cookie;

class AuthorisationService
{
	private $us;

	public function __construct(UserService $userService)
	{
	    $this->us = $userService;
	}

	public function isAuthenticate(Request $request){

		//if (!$request->isXmlHttpRequest()) return null;
		//if (!$request->isSecure()) return null;
		
		$uid = $request->cookies->get(CookieName::UID);
		$token = $request->cookies->get(CookieName::TOKEN);
		if (empty($uid)) return null;
		if (empty($token)) return null;

		$user = $this->us->getUser($uid);
		if( $user != null){
			if ($user->getToken() === $token){
				return $user;
			}
		}
		return null;
	}

	public function setCookies(Response $response, $uidCookie, $tokenCookie){
		$uidCookie = new Cookie(CookieName::UID, $uidCookie,time() + (1 * 365 * 24 * 60 * 60));
		$tokenCookie = new Cookie(CookieName::TOKEN, $tokenCookie,time() + (1 * 365 * 24 * 60 * 60));
		$response->headers->setCookie($uidCookie);
		$response->headers->setCookie($tokenCookie);
	}
}