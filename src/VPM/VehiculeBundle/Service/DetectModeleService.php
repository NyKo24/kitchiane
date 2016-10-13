<?php
namespace VPM\VehiculeBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class DetectModeleService {
	
	protected $em;
	
	public function __construct(EntityManager $em)
	{
		$this->em = $em;
	}
	
	public function detection(GetResponseEvent $event)
	{
		if (!$event->getRequest()->getSession()->get("vehicule",null))
		{
			if ($event->getRequest()->cookies->get("modeleVehicule",null))
			{
				$modele = $this->em->getRepository("VPMVehiculeBundle:Modele")->find($event->getRequest()->cookies->get("modeleVehicule"));
				$array = array(
						"id" => $modele->getId(),
						"constructeur" => $modele->getConstructeur()->getNom(),
						"nom" => $modele->getNom(),
						"cylindre" => $modele->getCylindre()->getTaille(),
						"annee" => $modele->getAnnee()->getAnnee()
				);
				$event->getRequest()->getSession()->set("vehicule", $array);
			}
			
			
		}
		
		return;
	}
}