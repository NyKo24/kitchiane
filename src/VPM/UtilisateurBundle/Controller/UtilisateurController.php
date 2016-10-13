<?php

namespace VPM\UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VPM\UtilisateurBundle\Form\InscriptionType;
use Symfony\Component\HttpFoundation\Request;

class UtilisateurController extends Controller
{
	public function indexAction()
	{
		return $this->render('VPMUtilisateurBundle:Default:index.html.twig');
	}
	
	public function inscriptionAction()
	{
		
		$formInscription = $this->createForm(InscriptionType::class);
		
		return $this->render("VPMUtilisateurBundle:Utilisateur:inscription.html.twig",array(
				"formulaireInscription" => $formInscription->createView(),
		));
	}
	
	public function monCompteAction(Request $request)
	{
		return $this->render("VPMUtilisateurBundle:Utilisateur:moncompte.html.twig",array());
	}
	
	public function historiqueCommandeAction(Request $request)
	{
		return $this->render("VPMUtilisateurBundle:Utilisateur:historique_commande.html.twig",array());
	}
	
	public function mesAdressesAction(Request $request)
	{
		return $this->render("VPMUtilisateurBundle:Utilisateur:mesadresses.html.twig",array());
	}
	
	public function mesInformationsAction(Request $request)
	{
		return $this->render("VPMUtilisateurBundle:Utilisateur:mesinformations.html.twig",array());
	}
}
