<?php

namespace itoldyooBundle\Business\Service;
use itoldyooBundle\Entity\IToldyoo;
use itoldyooBundle\Entity\IToldyooReceiver;
use Doctrine\ORM\EntityManager;

class IToldyooService{ 

	private $em;

	public function __construct(EntityManager $entityManager)
	{
	    $this->em = $entityManager;
	}

	public function createIToldyoo(IToldyoo $itoldyoo){

		
		$this->em->getConnection()->beginTransaction(); // suspend auto-commit
		try {
		    $this->em->persist($itoldyoo);
		    $this->em->flush();
		    $this->em->getConnection()->commit();
		} catch (Exception $e) {
		    $this->em->getConnection()->rollback();
		    throw $e;
		}

	}
	public function getAllIToldyoo($uid){
		$limit = 10;
		$qb = $this->em->createQueryBuilder();
		$qb->select('i')
			->from('itoldyooBundle:IToldyoo', 'i')
			->where('i.user_id = :uid')
			->orderBy('i.creation_date', 'DESC')
			->setMaxResults( $limit )
			->setParameter('uid', $uid);

		$query = $qb->getQuery();
		try {	
			$results = $query->getResult();
		} catch (Exception $e) {
			$results = null;
			throw $e;
		}			
		return $results;
	}
	
}