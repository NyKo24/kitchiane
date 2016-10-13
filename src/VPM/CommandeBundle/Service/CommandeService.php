<?php
namespace VPM\CommandeBundle\Service;

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
	
	/**
	 * 
	 * @param array $panierSession
	 * @return \VPM\CommandeBundle\Entity\Commande
	 */
	public function createCommandeByPanier($panierSession)
	{
		$em = $this->em;
		 
		$panier = $em->getRepository("VPMCommandeBundle:Panier")->find($panierSession["id"]);
		$adresseFacturation = $em->getRepository("VPMUtilisateurBundle:Adresse")->find($panierSession["adresseFacturation"]->getId());
		$adresseLivraison = $em->getRepository("VPMUtilisateurBundle:Adresse")->find($panierSession["adresseLivraison"]->getId());
		$commande = new Commande();
	
		$commande->setPanier($panier);	 
		$commande->setAdresseFacturation($adresseFacturation);
		$commande->setAdresseLivraison($adresseLivraison);
		$commande->setReference(uniqid("com_"));
		$commande->setTransporteur($this->transporteurService->getTransporteur($panierSession["transporteur"]["nom"]));
		$commande->setEtat($this->getEtatEnPreparation());
		$commande->setTarifHtTransporteur($panierSession["transporteur"]["tarifHT"]);
		$panier->setCommande($commande);
		
		$em->persist($commande);
		$em->persist($panier);
		 
		return $commande;
	}
	
	public function envoyerConfirmationCommande(Commande $commande)
	{
		$message = \Swift_Message::newInstance()
		->setSubject('Confirmation de commande ' . $commande->getReference())
		->setFrom($this->container->getParameter("adresseMailCommande"),$this->container->getParameter("titreSite") . " Commande")
		->setTo($commande->getPanier()->getUtilisateur()->getEmail(), $commande->getPanier()->getUtilisateur()->getPrenom() . " " . $commande->getPanier()->getUtilisateur()->getNom())
		->setBody(
				$this->container->get("templating")->render(
						'VPMCommandeBundle:Email:confirmation_commande.html.twig',
						array(
								'reduction' => 0,
								"downloadFacture" => $this->factureService->getLinkToDownloadPDF($commande),
								"commande" => $commande
						)
						),
				'text/html'
				)
				/*
				 * If you also want to include a plaintext version of the message
		->addPart(
				$this->renderView(
						'Emails/registration.txt.twig',
						array('name' => $name)
						),
				'text/plain'
				)
		*/
		;
		$this->container->get('mailer')->send($message);
		
	}
	
	
	
	public function getEtatEnPreparation()
	{
		return $this->em->getRepository("VPMCommandeBundle:EtatCommande")->findOneByLibelle("En préparation");
	}
	
	public function getEtatExpedie()
	{
		return $this->em->getRepository("VPMCommandeBundle:EtatCommande")->findOneByLibelle("Expédiée");
	}
}