<?php

namespace VPM\CommandeBundle\Service;

use Doctrine\ORM\EntityManager;
use VPM\CommandeBundle\Entity\Panier;

class PanierService
{
	
	protected $em;
	
	
	public function __construct(EntityManager $entityManager)
	{
		$this->em = $entityManager;
	}
	
	/**
	 * Calcule le sous total TTC et HT du panier en session
	 * @param array $panierSession
	 * @return number[]
	 */
	public function getSousTotalPanier($panierSession)
	{
		$sousTotalHT = 0.0;
		$sousTotalTTC = 0.0;
		$produitId = array();
		if (isset($panierSession["produit"]))
		{
			foreach ($panierSession["produit"] as $idProduit => $quantite)
			{
				$produitId[] = $idProduit;
			}
	
			$produits = $this->em->getRepository("VPMProduitBundle:Produit")->findById($produitId);
			foreach ($produits as $produit)
			{
				$sousTotalHT += $produit->getPrixPublicHt() * $panierSession["produit"][$produit->getId()];
				$sousTotalTTC+= $produit->getPrixTTC() * $panierSession["produit"][$produit->getId()];
			}
		}
	
		return array(
				"ttc" => $sousTotalTTC,
				"ht" => $sousTotalHT
		);
	}
	
	public function getSousTotalObjetPanier(Panier $panier)
	{
		$sousTotalHT = 0.0;
		$sousTotalTTC = 0.0;

		$listeProduitPanier = $panier->getProduitPanier();

		foreach ($listeProduitPanier as $produitPanier)
		{
			$sousTotalHT += $produitPanier->getProduit()->getPrixPublicHt() * $produitPanier->getQuantite();
			$sousTotalTTC += $produitPanier->getProduit()->getPrixTTC() * $produitPanier->getQuantite();
		}

		return array(
				"ttc" => $sousTotalTTC,
				"ht" => $sousTotalHT
		);
	}
		
}