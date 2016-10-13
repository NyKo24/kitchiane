<?php

namespace VPM\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VPM\CommandeBundle\Entity\Commande;
use VPM\CommandeBundle\Form\CommandeType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Commande controller.
 *
 */
class CommandeController extends Controller
{
    /**
     * Lists all Commande entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commandes = $em->getRepository('VPMCommandeBundle:Commande')->findAll();

        return $this->render('VPMAdminBundle:commande:index.html.twig', array(
            'commandes' => $commandes,
        ));
    }

    /**
     * Creates a new Commande entity.
     *
     */
    public function newAction(Request $request)
    {
        $commande = new Commande();
        $form = $this->createForm('VPM\CommandeBundle\Form\CommandeType', $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('admin_commande_show', array('id' => $commande->getId()));
        }

        return $this->render('VPMAdminBundle:commande:new.html.twig', array(
            'commande' => $commande,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Commande entity.
     *
     */
    public function showAction(Commande $commande)
    {
    	
    	$deleteForm = $this->createDeleteForm($commande);
    	$a4 = null;
    	$a5 = null;
    	$urlEtiquette = null;
    	

    	if ($commande->getTransporteur() == $this->get("transporteur_service")->getMondialRelay() )
    	{
    		$urlEtiquette = $this->generateUrl("admin_commande_generateEtiquetteColissimoLaPoste");
    		if ($commande->getSuivi())
    		{
    			$result = $this->get("admin_mondial_relay_service")->getEtiquette($commande->getSuivi());
    			$a4 = $result["WSI2_GetEtiquettesResult"]["URL_PDF_A4"];
    			$a5 = $result["WSI2_GetEtiquettesResult"]["URL_PDF_A5"];
    		}
    	}
    	else if ($commande->getTransporteur() == $this->get("transporteur_service")->getCollisimoLaPoste() )
    	{
    		$urlEtiquette = $this->generateUrl("admin_commande_generateEtiquetteMondialRelay");
    		if ($commande->getSuivi())
    		{
    			// récupération des URL pour une expédition en colissimo suivi
    		}
    	}
   
        return $this->render('VPMAdminBundle:commande:show.html.twig', array(
            'commande' => $commande,
            'delete_form' => $deleteForm->createView(),
        	"A4" => $a4,
        	"A5" => $a5,
        	"urlGenerationEtiquette" => $urlEtiquette,
        ));
    }

    /**
     * Displays a form to edit an existing Commande entity.
     *
     */
    public function editAction(Request $request, Commande $commande)
    {
        $deleteForm = $this->createDeleteForm($commande);
        $editForm = $this->createForm('VPM\CommandeBundle\Form\CommandeType', $commande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('admin_commande_edit', array('id' => $commande->getId()));
        }

        return $this->render('VPMAdminBundle:commande:edit.html.twig', array(
            'commande' => $commande,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Commande entity.
     *
     */
    public function deleteAction(Request $request, Commande $commande)
    {
        $form = $this->createDeleteForm($commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commande);
            $em->flush();
        }

        return $this->redirectToRoute('admin_commande_index');
    }

    /**
     * Creates a form to delete a Commande entity.
     *
     * @param Commande $commande The Commande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commande $commande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_commande_delete', array('id' => $commande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    public function generationEtiquetteMondialRelayAction(Request $request)
    {
    	if ($request->isXmlHttpRequest())
    	{
    		$poids = $request->request->get("poids");
    		$commandeId = $request->request->get("commandeId");
    		
    		$em = $this->getDoctrine()->getManager();
    		$commande = $em->getRepository("VPMCommandeBundle:Commande")->find($commandeId);
    		
    		$commande->setPoids($poids);
    		
    		$result = $this->get("admin_mondial_relay_service")->createExpédition($commande);
    		
    		$expNum = $result["WSI2_CreationExpeditionResult"]["ExpeditionNum"];
    	
    		$commande->setSuivi($expNum);
    		
    		// prévenir le client de l'expédition de son colis
    		
    		$em->persist($commande);
    		$em->flush();
    		$result = $this->get("admin_mondial_relay_service")->getEtiquette($expNum);
    		
    		$objRetour = array(
    				"A4" => $result["WSI2_GetEtiquettesResult"]["URL_PDF_A4"],
    				"A5" => $result["WSI2_GetEtiquettesResult"]["URL_PDF_A5"],
    				"tarifReelHT" => ""
    		);
    		
    		
    		return new JsonResponse($objRetour);
    	}
    	
    	
    }
	
    public function generationEtiquetteColissimoLaPoste(Request $request){
    	
    }
}
