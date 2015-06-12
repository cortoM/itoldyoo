<?php

namespace itoldyooBundle\Business\Service;
use itoldyooBundle\Entity\User;
use itoldyooBundle\Entity\UserEmail;
use Doctrine\ORM\EntityManager;

class UserService{ 

	private $em;

	public function __construct(EntityManager $entityManager)
	{
	    $this->em = $entityManager;
	}

	public function createUser(User $user){
		$this->em->getConnection()->beginTransaction(); // suspend auto-commit
		try {
		    $this->em->persist($user);
		    $this->em->flush();
		    $this->em->getConnection()->commit();
		} catch (Exception $e) {
		    $this->em->getConnection()->rollback();
		    throw $e;
		}

	}
	public function updateUser(User $user){
		$this->em->getConnection()->beginTransaction(); // suspend auto-commit
		try {
		    $this->em->merge($user);
		    $this->em->flush();
		    $this->em->getConnection()->commit();
		} catch (Exception $e) {
		    $this->em->getConnection()->rollback();
		    throw $e;
		}

	}

	public function getUser($id){
		
		$qb = $this->em->createQueryBuilder();
		$qb->select('u')
			->from('itoldyooBundle:User', 'u')
			->where('u.id = :id')
			->setParameter('id', $id);
		$query = $qb->getQuery();
		try {	
			$user = $query->getSingleResult();
		} catch (Exception $e) {
			$user = null;
			throw $e;
		}			
		return $user;
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