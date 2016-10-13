<?php
namespace VPM\AdminBundle\Service;

use Doctrine\ORM\EntityManager;
use VPM\CommandeBundle\Entity\Commande;
use VPM\TransporteurBundle\Service\TransporteurService;
use Symfony\Component\DependencyInjection\ContainerInterface;
class MondialRelayService
{
	
	protected $em;
	
	protected $container;

	public function __construct(EntityManager $entityManager, ContainerInterface $container )
	{
		$this->em = $entityManager;
		$this->container = $container;
	}
	
	public function sendRequest($endpoint,$params)
	{
		$MR_WebSiteId = $this->container->getParameter("codeEnseingeMondialRelay");
		$MR_WebSiteKey = $this->container->getParameter("cleSecreteMondialRelay");
		$client = new \nusoap_client("http://api.mondialrelay.com/Web_Services.asmx?WSDL", true);
		$client->soap_defencoding = 'utf-8';
		
		// On génère la clé de sécurité de l'appel
		$code = implode("", $params);
		$code .= $MR_WebSiteKey;
		$params["Security"] = strtoupper(md5($code));
		// On réalise l'appel et stocke le résultat dans la variable $result
		$result = $client->call(
				$endpoint,
				$params,
				'http://api.mondialrelay.com/', 'http://api.mondialrelay.com/'.$endpoint
				);
		
		return $result;
	}
	
	public function getRelai()
	{
		$MR_WebSiteId = $this->container->getParameter("codeEnseingeMondialRelay"); 
		$MR_WebSiteKey = $this->container->getParameter("cleSecreteMondialRelay");
		$client = new \nusoap_client("http://api.mondialrelay.com/Web_Services.asmx?WSDL", true); 
		$client->soap_defencoding = 'utf-8';
		// We define the parameters as a string array. Each Key/Val represents a parameter of the soap call
		// On défini les paramètres dans un tableau de chaînes. Chaque paire Clé/Valeur est un paramètre de l'appel SOAP
		$params = array(
				'Enseigne' => $MR_WebSiteId, 'Pays' => "FR", 
				//'NumPointRelais' => "",
				'Ville' => "",
				'CP' => "75010",
				'Latitude' => "", 'Longitude' => "",
				'Taille' => "",
				'Poids' => "",
				'Action' => "", 'DelaiEnvoi' => "0", 'RayonRecherche' => "20", 
				//'TypeActivite' => "",
				//'NACE' => "", 
				);
		// On génère la clé de sécurité de l'appel
				$code = implode("", $params);
				$code .= $MR_WebSiteKey; 
				$params["Security"] = strtoupper(md5($code));
				// On réalise l'appel et stocke le résultat dans la variable $result 
				$result = $client->call(
				'WSI3_PointRelais_Recherche',
				$params,
				'http://api.mondialrelay.com/', 'http://api.mondialrelay.com/WSI3_PointRelais_Recherche'
				);
				
				return $result;
	}
	
	public function createExpédition(Commande $commande)
	{
		$params = array(
				'Enseigne' => $this->container->getParameter("codeEnseingeMondialRelay"), 
				'ModeCol' => "REL",
				'ModeLiv' => "24R",
				'NDossier' => $commande->getId(),
				'NClient' => $commande->getPanier()->getUtilisateur()->getId(),
				'Expe_Langage' => "FR",
				"Expe_Ad1" => $this->container->getParameter("nomExpediteurMondialRelay"),
				"Expe_Ad2" => "",
				"Expe_Ad3" => "Route de Bergerac",
				"Expe_Ad4" => "",
				"Expe_Ville" => "COULOUNIEIX-CHAMIERS",
				"Expe_CP" => "24660",
				"Expe_Pays" => "FR",
				"Expe_Tel1" => $this->container->getParameter("telMobile"),
				"Expe_Tel2" => "",
				"Expe_Mail" => $this->container->getParameter("adresseMailContant"),
				"Dest_Langage" => "FR",
				"Dest_Ad1" => $commande->getPanier()->getUtilisateur()->getCivilite()->getLibelle() ." ".$commande->getAdresseLivraison()->getPrenom(). " " . $commande->getAdresseFacturation()->getNom(),
				"Dest_Ad2" => "",
				"Dest_Ad3" => $commande->getAdresseLivraison()->getLigne1(),
				"Dest_Ad4" => $commande->getAdresseLivraison()->getLigne2(),
				"Dest_Ville" => $commande->getAdresseLivraison()->getVille(),
				"Dest_CP" => $commande->getAdresseLivraison()->getCp(),
				"Dest_Pays" => "FR",
				"Dest_Tel1" => $commande->getPanier()->getUtilisateur()->getTelPortable(),
				"Dest_Tel2" => $commande->getPanier()->getUtilisateur()->getTelFixe(),
				"Dest_Mail" => $commande->getPanier()->getUtilisateur()->getEmail(),
				"Poids" => $commande->getPoids(),
				"Longueur" => "",
				"Taille" => "",
				"NbColis" => 1,
				"CRT_Valeur" => 0,
				"CRT_Devise" => "EUR",
				"Exp_Valeur" => "",
				"Exp_Devise" => "EUR",
				"COL_Rel_Pays" => "FR",
				"COL_Rel" => "023221",
				"LIV_Rel_Pays" => $commande->getRelai()->getPays(),
				"LIV_Rel" => $commande->getRelai()->getIdMondialRelay(),
				"TAvisage" => "",
				"TReprise" => "",
				"Montage" => "",
				"TRDV" => "",
				"Assurance" => "",
				"Instructions"=>"",
			);

		return $this->sendRequest("WSI2_CreationExpedition", $params);
	}
	
	public function getEtiquette($expNum)
	{
		$params = array(
				"Enseigne" => $this->container->getParameter("codeEnseingeMondialRelay"),
				"Expeditions" => $expNum,
				"Langue" => "FR",
		);
		return $this->sendRequest("WSI2_GetEtiquettes", $params);
	}

	public function getSrc()
	{
		$params = array(
				"ens"=> $this->container->getParameter("codeEnseingeMondialRelay"),
				"expedition" => "31151139",
				"lg" => "FR",
				"format" => "A4",
		);
		$code = implode("", $params);
		$code .= $this->container->getParameter("cleSecreteMondialRelay");
		$params["Security"] = strtoupper(md5($code));
		
		return $params["Security"];
	}
}