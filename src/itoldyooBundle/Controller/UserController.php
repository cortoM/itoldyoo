<?php

namespace itoldyooBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use itoldyooBundle\Business\DTO\ErrorDTO;
use itoldyooBundle\Business\DTO\DefaultDTO;
use itoldyooBundle\Business\DTO\EmailsDTO;
use itoldyooBundle\Business\DTO\UserLastEmailDTO;
use itoldyooBundle\Business\DTO\IToldyooDTO;
use itoldyooBundle\Business\DTO\IToldyooListDTO;
use itoldyooBundle\Business\DTO\NewIToldyooCTO;
use itoldyooBundle\Business\Common\ResponseCode;
use itoldyooBundle\Business\Common\UserType;
use itoldyooBundle\Business\Common\UserEmailOrigin;
use itoldyooBundle\Entity\User;
use itoldyooBundle\Entity\UserEmail;
use itoldyooBundle\Entity\IToldyoo;
use itoldyooBundle\Entity\IToldyooReceiver;
use itoldyooBundle\Business\Common\IToldyooStatus;
use itoldyooBundle\Business\Common\IToldyooReceiverStatus;

class UserController extends Controller
{
	private $serializer;

	public function __construct(){
		
		$encoders = array(new XmlEncoder(), new JsonEncoder());
		$normalizers = array(new GetSetMethodNormalizer());
		$this->serializer = new Serializer($normalizers, $encoders);
	}
	public function getIToldyooAction(Request $request)
	{   
		try{
			$authService = $this->get('auth_service');
			$t = $this->get('translator');
			$user = $authService->isAuthenticate($request);
			if ( is_null($user)){			
				$errorDTO = new ErrorDTO($t->trans("error.message.type1"),ResponseCode::ERROR);
				$response = new Response($this->serializer->serialize($errorDTO, 'json'), 200);
			}
			else{
				$itoldyooService = $this->get('itoldyoo_service');
				$itoldyoos = $itoldyooService->getAllIToldyoo($user->getId());
				
				$iToldyooListDTO = new IToldyooListDTO();

				foreach ( $itoldyoos as $itoldyoo ){

					$iToldyooDTO = new IToldyooDTO();
					$iToldyooDTO->setDescription($itoldyoo->getDescription());
					if (!empty($itoldyoo->getCreationDate())) 
						$iToldyooDTO->setCreationDate($itoldyoo->getCreationDate()->format('Y-m-d H:i:s'));
					if (!empty($itoldyoo->getScheduledDate())) 
						$iToldyooDTO->setScheduledDate($itoldyoo->getScheduledDate()->format('Y-m-d H:i:s'));
					$statusTranslation = $t->trans(IToldyooStatus::getTextKey($itoldyoo->getStatus()));
					$iToldyooDTO->setStatus($statusTranslation);
					$iToldyooListDTO->addItoldyooDTO($iToldyooDTO);
				}

				$iToldyooListDTO->setCode(ResponseCode::OK);
				$response = new Response($this->serializer->serialize($iToldyooListDTO, 'json'), 200);
			}
		}
		catch (Exception $e) {
			$errorDTO = new ErrorDTO("error =".$e->getMessage(),ResponseCode::ERROR);
			$response = new Response($this->serializer->serialize($errorDTO, 'json'), 200);

		}

//		$request->getPreferredLanguage(array('en', 'fr'));

		$response->headers->set('Content-Type', 'application/json');
		return $response;

	}
	public function getEmailsAction(Request $request)
	{
		try{
			$authService = $this->get('auth_service');
			$t = $this->get('translator');

			$user = $authService->isAuthenticate($request);
			if ( is_null($user)){
				$errorDTO = new ErrorDTO($t->trans("error.message.type1"),ResponseCode::ERROR);
				$response = new Response($this->serializer->serialize($errorDTO, 'json'), 200);
			}
			else{
				$emails = $user->getEmails();
				$emailsDTO = new EmailsDTO(ResponseCode::OK);
				foreach ($emails as $email){
					$emailsDTO->addEmail($email->getEmail());
				}
				$response = new Response($this->serializer->serialize($emailsDTO, 'json'), 200);
			}
		}
		catch (Exception $e) {
			$errorDTO = new ErrorDTO("error =".$e->getMessage(),ResponseCode::ERROR);
			$response = new Response($this->serializer->serialize($errorDTO, 'json'), 200);
		}

		$response->headers->set('Content-Type', 'application/json');
		return $response;

	}
	public function getUserLastEmailAction(Request $request)
	{	
	
		try{
			$authService = $this->get('auth_service');
			$t = $this->get('translator');

			$user = $authService->isAuthenticate($request);
			if ( is_null($user)){
				$errorDTO = new ErrorDTO($t->trans("error.message.type1"),ResponseCode::ERROR);
				$response = new Response($this->serializer->serialize($errorDTO, 'json'), 200);
			}
			else{
				$userLastEmailCTO = new UserLastEmailDTO(ResponseCode::OK);
				$userLastEmailCTO->setEmail($user->getEmail());
				$response = new Response($this->serializer->serialize($userLastEmailCTO, 'json'), 200);
			}

		}
		catch (Exception $e) {
			$errorDTO = new ErrorDTO("error =".$e->getMessage(),ResponseCode::ERROR);
			$response = new Response($this->serializer->serialize($errorDTO, 'json'), 200);

		}
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	public function createIToldyooAction(Request $request)
	{	
	
		try{
			$json = $this->get("request")->getContent();
			if (empty($json)){
				$errorDTO = new ErrorDTO("empty itoldyoo",ResponseCode::ERROR);
				$response = new Response($this->serializer->serialize($errorDTO, 'json'), 200);
				$response->headers->set('Content-Type', 'application/json');
				return $response;
			}
			$newIToldyooCTO = $this->serializer->deserialize($json,'itoldyooBundle\Business\DTO\NewIToldyooCTO','json');
			if (!$newIToldyooCTO->isValid()){
				$errorDTO = new ErrorDTO("invalid itoldyoo",ResponseCode::ERROR);
				$response = new Response($this->serializer->serialize($errorDTO, 'json'), 200);
				$response->headers->set('Content-Type', 'application/json');
				return $response;
			}
			$authService = $this->get('auth_service');
			$userService = $this->get('user_service');
			//test if the user is known thanls to cookies
			$user = $authService->isAuthenticate($request);
			if ( is_null($user)){
				//we have to create a new user
				$user = new User();
				$user->setType(UserType::USER);
				$user->setCreationDate(new \DateTime("now"));
				$user->setToken($userService->gen_uuid());
				$user->setEmail($newIToldyooCTO->getEmail());
				foreach ( $newIToldyooCTO->getEmails() as $email )
				{
					$userEmail = new UserEmail();
					$userEmail->setEmail($email);
					$userEmail->setCreationDate(new \DateTime("now"));
					$userEmail->setOrigin(UserEmailOrigin::PROVIDED);
					$user->addEmail($userEmail);			
				}
				$userService->createUser($user);
			}
			else{
				//TODO update user email
				$user->setEmail($newIToldyooCTO->getEmail());
				$userService->updateUser($user);
			}
			if ( is_null($user)){
				$errorDTO = new ErrorDTO("could not find user",ResponseCode::ERROR);
				$response = new Response($this->serializer->serialize($errorDTO, 'json'), 200);
				$response->headers->set('Content-Type', 'application/json');
				return $response;
			}
			// we have a user - create the Itoldyoo in DB from the user
			$itoldyooService = $this->get('itoldyoo_service');
			$itoldyoo = new IToldyoo();
			$itoldyoo->setDescription($newIToldyooCTO->getDescription());
			$itoldyoo->setSenderEmail($newIToldyooCTO->getEmail());
			$itoldyoo->setUserId($user->getId());
			$itoldyoo->setScheduledDate(new \DateTime($newIToldyooCTO->getScheduledDate()));
			$itoldyoo->setCreationDate(new \DateTime("now"));
			$itoldyoo->setLastUpdateDate(new \DateTime("now"));
			$itoldyoo->setStatus(IToldyooStatus::TODO);
			$itoldyoo->setIPAddress($request->getClientIp());
			foreach ( $newIToldyooCTO->getEmails() as $email )
			{
				$iToldyooReceiver = new IToldyooReceiver();
				$iToldyooReceiver->setReceiverEmail($email);
				$iToldyooReceiver->setCreationDate(new \DateTime("now"));
				$iToldyooReceiver->setStatus(IToldyooReceiverStatus::TODO);
				$itoldyoo->addReceiver($iToldyooReceiver);			
			}		 

			$itoldyooService->createIToldyoo($itoldyoo);
			//create the response
			$defaultDTO = new DefaultDTO(ResponseCode::OK);
			$response = new Response($this->serializer->serialize($defaultDTO, 'json'), 200);
			//set the cookies values
			$authService->setCookies($response, $user->getId(),$user->getToken());
		}
		catch (Exception $e) {
			$errorDTO = new ErrorDTO("error =".$e->getMessage(),ResponseCode::ERROR);
			$response = new Response($this->serializer->serialize($errorDTO, 'json'), 200);

		}
		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

}