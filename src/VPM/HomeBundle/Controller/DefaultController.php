<?php

namespace VPM\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$produits = $em->getRepository("VPMProduitBundle:Produit")->findAll();
        return $this->render('VPMHomeBundle:Default:index.html.twig',array(
        		"produits" => $produits,
        ));
    }
}
