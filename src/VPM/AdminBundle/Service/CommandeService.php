<?php
namespace VPM\AdminBundle\Service;

use Doctrine\ORM\EntityManager;
use VPM\CommandeBundle\Entity\Commande;
use VPM\TransporteurBundle\Service\TransporteurService;
use Symfony\Component\DependencyInjection\ContainerInterface;
class CommandeService
{
	
	protected $em;
	
	protected $transporteurService;
	
	protected $factureService;
	
	protected $container;
	
	
	public function __construct(EntityManager $entityManager, TransporteurService $transporteurService, FactureService $factureService, ContainerInterface $container )
	{
		$this->em = $entityManager;
		$this->transporteurService = $transporteurService;
		$this->factureService = $factureService;
		$this->container = $container;
	}
	
}