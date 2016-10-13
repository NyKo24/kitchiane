<?php

namespace VPM\CommandeBundle\Service;

use Doctrine\ORM\EntityManager;

class MethodePaiementService
{
	
	protected $em;
	
	public function __construct(EntityManager $entityManager)
	{
		$this->em = $entityManager;

	}
	
	public function getPayPal()
	{
		return $this->em->getRepository("VPMCommandeBundle:MethodePaiement")->findOneByLibelle(array("PayPal"));
	}
	
	public function getPayPlug()
	{
		return $this->em->getRepository("VPMCommandeBundle:MethodePaiement")->findOneByLibelle(array("PayPlug"));
	}
}