<?php

namespace VPM\TransporteurBundle\Service;

use Doctrine\ORM\EntityManager;
use VPM\CommandeBundle\Service\PanierService;

class TransporteurService
{
	
	protected $em;
	
	protected $panierService;
	
	public function __construct(EntityManager $entityManager, PanierService $panierService)
	{
		$this->em = $entityManager;
		$this->panierService = $panierService;
	}
	
	/**
	 * Retourne le transporteur Colissimo La poste
	 * @return Transporteur
	 */
	public function getCollisimoLaPoste()
	{
		return $this->em->getRepository("VPMTransporteurBundle:Transporteur")->findOneByNom("Colissimo La Poste");
	}
	
	/**
	 * Retourne le transporteur Mondial Relay
	 * @return Transporteur
	 */
	public function getMondialRelay()
	{
		return $this->em->getRepository("VPMTransporteurBundle:Transporteur")->findOneByNom("Mondial Relay");
	}
	
	public function getTransporteur($nom)
	{
		switch (trim($nom))
		{
			case "colissimoLaPoste":
				return $this->getCollisimoLaPoste();
				break;
	
			case "mondialRelay":
				return $this->getMondialRelay();
				break;
	
			default:
				return null;
		}
	}
	
	public function calculeFdp($panierSession,$transporteur = null)
	{
		$ht = 0;
		$ttc = 0;
		$sousTotalTTC = $this->panierService->getSousTotalPanier($panierSession)["ttc"];
		switch ($transporteur)
		{
			case "colissimoLaPoste":
				if ( $sousTotalTTC <= 25.00)
				{
					$ht = 8.25;
				}
				elseif ($sousTotalTTC > 25.00)
				{
					$ht = 4.92;
				}
				break;
			case "mondialRelay":
				if ( $sousTotalTTC <= 25.00)
				{
					$ht = 3.25;
				}
				elseif ($sousTotalTTC > 25.00)
				{
					$ht = 0.00;
				}
				break;
			default: if ( $sousTotalTTC <= 25.00)
				{
					$ht = 3.25;
				}
				elseif ($sousTotalTTC > 25.00)
				{
					$ht = 0.00;
				}
			break;
		}
	
		return array(
				"ht" => $ht,
				"ttc" => $ht * 1.2
		);
	}
}