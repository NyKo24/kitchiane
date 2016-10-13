<?php

namespace VPM\ProduitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use VPM\ProduitBundle\VPMProduitBundle;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends Controller
{
    public function indexAction()
    {
        return $this->render('VPMProduitBundle:Default:index.html.twig');
    }
    
    public function afficherCategorieAction(Request $request, $slug)
    {
    	
		$categorie = $this->getDoctrine()->getManager()->getRepository("VPMProduitBundle:Categorie")->findOneBySlug($slug);
    	
		$produits = $categorie->getProduits();
		if ($request->get("nbProduitPage",null))
		{
			$nbProduitPage = $request->get("nbProduitPage");
		}
		else 
		{
			$nbProduitPage = $this->getParameter("nbProduitPage");
		}
		
		
		$subTab = array();
		$nbPageTotal = 0;
		$produitAAfficher = array();
		$currentPage = $request->get("page",null);		
		$currentPage = is_null($currentPage) ? 1 : $currentPage;
		$arrProduit = $produits->getValues();
		if (count($arrProduit) > 0)
		{
			$subTab = array_chunk($arrProduit, $nbProduitPage);
			$nbPageTotal = count($subTab);
			if ($currentPage && isset($subTab[$currentPage - 1]))
			{
				$produitAAfficher = $subTab[$currentPage - 1];
			}

		}
		return $this->render("VPMProduitBundle:Categorie:afficherCategorie.html.twig",array(
				"produits" => $produitAAfficher,
				"categorie" => $categorie,
				"nbPageTotal" => $nbPageTotal,
				"currentPage" => $currentPage,
				"nbProduitPage" => $nbProduitPage,
				"slug" => $slug
		));
    }
    
    public function fileArianeAction($produitId)
    {
    	$produit = $this->getDoctrine()->getManager()->getRepository("VPMProduitBundle:Produit")->find($produitId);
    	$categories = $produit->getCategories();
    	$arr = $this->ariane($categories->first());
    	$arr = array_reverse($arr);
    	$str = "";
    	for ($i = 0; $i < count($arr); $i++)
    	{
    		if ($i == count($arr) )
    			$str .= $arr[$i];
    		else 
    			$str .= $arr[$i] . " > ";
    	}
    	return new Response(count($arr));
    }
    
    private function ariane($categorie)
    {
    	$array[] = $categorie->getNom();
    	if ($categorie->getParent())
    	{
    		$array[] = $this->ariane($categorie->getParent());
    		return $array;
    	}
    	else 
    		return $array;
    }
    
    public function navBarAction()
    {
    	$categories = $this->getDoctrine()->getManager()->getRepository("VPMProduitBundle:Categorie")->findAll();
    	return $this->render("VPMProduitBundle:Categorie:navBarCategorie.html.twig",array("categories"=>$categories));
    }
}
