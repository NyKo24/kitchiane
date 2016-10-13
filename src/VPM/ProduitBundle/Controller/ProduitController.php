<?php

namespace VPM\ProduitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProduitController extends Controller
{
    public function indexAction()
    {
        return $this->render('VPMProduitBundle:Default:index.html.twig');
    }
    
    public function afficherProduitAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        
        $repoProduit = $em->getRepository("VPMProduitBundle:Produit");
        
        $produit = $repoProduit->findOneBySlug($slug);
        if (is_null($produit))
            return new Response("Aucun produit");
        else 
            return $this->render('VPMProduitBundle:Produit:pageProduit.html.twig',array("produit"=>$produit));
    }
}

