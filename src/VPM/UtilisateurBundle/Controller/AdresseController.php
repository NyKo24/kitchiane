<?php

namespace VPM\UtilisateurBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use VPM\UtilisateurBundle\Entity\Adresse;
use VPM\UtilisateurBundle\Form\AdresseType;

/**
 * Adresse controller.
 *
 */
class AdresseController extends Controller
{
    /**
     * Lists all Adresse entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $adresses = $em->getRepository('VPMUtilisateurBundle:Adresse')->findAll();

        return $this->render('adresse/index.html.twig', array(
            'adresses' => $adresses,
        ));
    }

    /**
     * Creates a new Adresse entity.
     *
     */
    public function newAction(Request $request)
    {
        $adresse = new Adresse();
        $form = $this->createForm('VPM\UtilisateurBundle\Form\AdresseType', $adresse);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($adresse);
            $em->flush();

            return $this->redirectToRoute('adresse_show', array('id' => $adresse->getId()));
        }

        return $this->render('adresse/new.html.twig', array(
            'adresse' => $adresse,
            'form' => $form->createView(),
        ));
    }

    
    /**
     * Finds and displays a Adresse entity.
     *
     */
    public function showAction(Adresse $adresse)
    {
        $deleteForm = $this->createDeleteForm($adresse);

        return $this->render('adresse/show.html.twig', array(
            'adresse' => $adresse,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Adresse entity.
     *
     */
    public function editAction(Request $request, Adresse $adresse)
    {
        $deleteForm = $this->createDeleteForm($adresse);
        $editForm = $this->createForm('VPM\UtilisateurBundle\Form\AdresseType', $adresse);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($adresse);
            $em->flush();

            return $this->redirectToRoute('adresse_edit', array('id' => $adresse->getId()));
        }

        return $this->render('adresse/edit.html.twig', array(
            'adresse' => $adresse,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Adresse entity.
     *
     */
    public function deleteAction(Request $request, Adresse $adresse)
    {
        $form = $this->createDeleteForm($adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($adresse);
            $em->flush();
        }

        return $this->redirectToRoute('adresse_index');
    }

    /**
     * Creates a form to delete a Adresse entity.
     *
     * @param Adresse $adresse The Adresse entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Adresse $adresse)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('adresse_delete', array('id' => $adresse->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    public function sauverAdresseFacturationAction(Request $request)
    {

    	$user = $this->getDoctrine()->getManager()->getRepository("VPMUtilisateurBundle:Utilisateur")->find($this->getUser()->getId());
    	$adresseFacturation = $user->getAdresseFacturation();
    	if (is_null($adresseFacturation))
    	{
    		$adresseFacturation = new Adresse();
    		$repoTypeAdresse = $this->getDoctrine()->getManager()->getRepository("VPMUtilisateurBundle:TypeAdresse");
    		$typeFacturation = $repoTypeAdresse->findOneByLibelle("facturation");
    		$adresseFacturation->setUtilisateur($user);
    		$adresseFacturation->setType($typeFacturation);
    		$adresseFacturation->setDefaut(true);
    	}
    		
    	$formeFacturation = $this->createForm('VPM\UtilisateurBundle\Form\AdresseType', $adresseFacturation);
    	 
    	$formeFacturation->remove("utilisateur");
    	$formeFacturation->remove("type");
    	$formeFacturation->remove("defaut");
    	
    	$formeFacturation->handleRequest($request);
    	if ($formeFacturation->isSubmitted() && $formeFacturation->isValid()) {
    		$em = $this->getDoctrine()->getManager();
    		$em->persist($adresseFacturation);
    		$em->flush();
    		// mettre en session
    		$panier = $request->getSession()->get("panier");
    		$panier["adresseFacturation"] = $adresseFacturation;
    		$request->getSession()->set("panier", $panier);
    		$request->getSession()->getFlashBag()->add('success', "L'adresse de facturation a été enregistrée.");
    		return $this->redirectToRoute("vpm_panier_livraison");
    	}
    }
    
    public function sauverAdresseLivraisonAction(Request $request)
    {
    	$user = $this->getDoctrine()->getManager()->getRepository("VPMUtilisateurBundle:Utilisateur")->find($this->getUser()->getId());
    	$adresseLivraison = $user->getAdresseLivraison();
    	if (is_null($adresseLivraison))
    	{
    		$adresseLivraison = new Adresse();
    		$repoTypeAdresse = $this->getDoctrine()->getManager()->getRepository("VPMUtilisateurBundle:TypeAdresse");
    		$typeLivraison = $repoTypeAdresse->findOneByLibelle("livraison");
    		$adresseLivraison->setUtilisateur($user);
    		$adresseLivraison->setType($typeLivraison);
    		$adresseLivraison->setDefaut(true);
    	}
    
    	$formLivraison = $this->createForm('VPM\UtilisateurBundle\Form\AdresseType', $adresseLivraison);
    
    	$formLivraison->remove("utilisateur");
    	$formLivraison->remove("type");
    	$formLivraison->remove("defaut");
    	$formLivraison->remove("siret");
    	$formLivraison->remove("tva");
    	 
    	$formLivraison->handleRequest($request);
    	if ($formLivraison->isSubmitted()) {
    		if (!$formLivraison->isValid())
    		{
    			
    			$request->getSession()->getFlashBag()->add('error', "L'adresse de livraison comporte une erreur, merci de corriger.");
    		}
    		else 
    		{
    			$em = $this->getDoctrine()->getManager();
    			$em->persist($adresseLivraison);
    			$em->flush();
    			// mettre en session
    			$panier = $request->getSession()->get("panier");
    			$panier["adresseLivraison"] = $adresseLivraison;
    			$request->getSession()->set("panier", $panier);
    			$request->getSession()->getFlashBag()->add('success', "L'adresse de livraison a été enregistrée.");
    		}
    		
    		return $this->redirectToRoute("vpm_panier_livraison");
    	}
    }
}
