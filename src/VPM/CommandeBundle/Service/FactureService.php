<?php

namespace VPM\CommandeBundle\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use VPM\CommandeBundle\Entity\Commande;
use Doctrine\ORM\EntityManager;

class FactureService
{
	protected $em;
	
	protected $container;
	
	protected $panierService;
	
	protected $url;
	
	protected $token; 
	public function __construct(EntityManager $entityManager,ContainerInterface $container, PanierService $panierService)
	{
		$this->em = $entityManager;
		$this->container = $container;
		$this->panierService = $panierService;
		
		$this->url = $this->container->getParameter("urlVosFacture");
		$this->token = $this->container->getParameter("tokenVosFacture");
	}
	
	public function makeFacture(Commande $commande)
	{
		
		$client = $commande->getPanier()->getUtilisateur();

		$produitsSession = $commande->getPanier()->getProduitPanier();
		$adresseFacturation = $commande->getAdresseFacturation();
		$panier = $commande->getPanier();
		$transporteur = $commande->getTransporteur();
		
		$montantTtc = $this->panierService->getSousTotalObjetPanier($commande->getPanier())["ttc"];
		
		$refCommande = $commande->getReference();
		// a récupérer depuis la commande
		$paiementType = "card";
	
		$jsonProduits = array();
	
		foreach ($produitsSession as $produitPanier)
		{
			$produit = $produitPanier->getProduit();
			$quantite = $produitPanier->getQuantite();
			
			$jsonProduit = array(
					"product_id" => $produit->getId(),
					"name" => $produit->getNom(),
					"code" => $produit->getReferenceSite(),
					"quantity" => $quantite,
					"quantity_unit" => "pc",
					"price_net" => $produit->getPrixPublicHt(),
					"tax" => "20",
					"total_price_gross" => $produit->getPrixTTC() * $quantite
			);
			$jsonProduits[]= $jsonProduit;
		}
		
		$jsonProduit = array(
					"product_id" => $transporteur->getId(),
					"name" => "Livraison : " . $transporteur->getNom() ." " . $transporteur->getDescription(),
					"code" => $transporteur->getId(),
					"quantity" => 1,
					"quantity_unit" => "pc",
					"price_net" => $commande->getTarifHtTransporteur(),
					"tax" => "20",
					"total_price_gross" => $commande->getTarifHtTransporteur()*1.2
			);
		
		$jsonProduits[] = $jsonProduit;
	
		$montantTtc += $commande->getTarifHtTransporteur()*1.2;
		$param = array(
				'api_token' => $this->token,
				"invoice" => array(
						"kind" => "vat",
						"issue_date" => date("d-m-Y"),
						"place" => "COULOUNIEIX-CHAMIERS",
						"sell_date" => date("d-m-Y"),
						"seller_name" => "VPM Racing SASU",
						"seller_tax_no" => "FR96 803696632",
						"seller_post_code" => "24660",
						"seller_city" => "COULOUNIEIX-CHAMIERS",
						"seller_street" => "Centre d'affaire - Route de Bergerac",
						"seller_country" => "FRANCE",
						"seller_email" => "contact@vpmracing.com",
						"seller_www" => "http://www.vpmracing.com",
						"seller_phone" => "+33 6 65 23 10 24",
						"client_id" => "-1",
						"buyer_name" => $adresseFacturation->getSociete() . " " . ucfirst(strtolower($client->getPrenom())) . " " . strtoupper($client->getNom()),
						"buyer_tax_no" => "TVA : " . $adresseFacturation->getTva() . " SIRET : " . $adresseFacturation->getSiret(),
						"buyer_post_code" => $adresseFacturation->getCp(),
						"buyer_city" => $adresseFacturation->getVille(),
						"buyer_street" => $adresseFacturation->getLigne1() . " " . $adresseFacturation->getLigne2() . " " . $adresseFacturation->getComplement(),
						"buyer_country" => "FRANCE",
						"buyer_email" => $client->getEmail(),
						"payment_type" => $paiementType,
						"payment_to" => date("d-m-Y"),
						"status" => "paid",
						"paid" => $montantTtc,
						"oid" => $refCommande,
						"oid_unique" => "yes",
						"buyer_first_name" => $client->getPrenom(),
						"buyer_last_name" => $client->getNom(),
						"buyer_company" => (is_null($adresseFacturation->getSociete()) ? 0 : 1),
						"paid_date" => date('d-m-Y'),
						"currency" => "EUR",
						"lang" => "fr",
						"title" => "Commande ref : " . $refCommande. " - " . $client->getNom(),
						"invoice_template_id" => 1,
						"description_footer" => "VPM Racing SASU - Capital social de 1500 EUROS - Immatriculé au RCS de Périgueux sous le numéro 803 696 632",
						"positions" => $jsonProduits
				)
		);
		 
		$ch = curl_init($this->url ."/invoices.json");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen(json_encode($param)),
				'Accept: application/json'
		));
	
		$result = curl_exec($ch);
		 
		$result = json_decode($result);
		$commande->setFactureId($result->id);
		$commande->setFactureToken($result->token);

		return $commande;
	}
	
	public function getTokenFacture($factureId)
	{
		$ch = curl_init($this->url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($param));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen(json_encode($param)),
				'Accept: application/json'
		));
	}
	
	public function getLinkToDownloadPDF(Commande $commande)
	{
		return $this->url . "/invoice/".$commande->getFactureToken().".pdf";
	}
}