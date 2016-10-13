<?php

namespace VPM\VehiculeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

class ModeleController extends Controller
{
    public function listeAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	if ($request->isXmlHttpRequest()){
    	
    		if ($request->get("type",null) && $request->get("marque",null) && $request->get("cylindre",null))
    		{
    			$type = $em->getRepository("VPMVehiculeBundle:TypeVehicule")->find($request->get("type"));
    			$cylindre = $em->getRepository("VPMVehiculeBundle:Cylindre")->find($request->get("cylindre"));
    			$constructeur = $em->getRepository("VPMVehiculeBundle:Constructeur")->find($request->get("marque"));
    			$modeles = $em->getRepository("VPMVehiculeBundle:Modele")->findBy(
    					array("cylindre" => $cylindre, "type"=>$type, "constructeur" => $constructeur )
    					);

    			$modeles = $em->getRepository("VPMVehiculeBundle:Modele")
    			->createQueryBuilder('modele')
    			->select('DISTINCT modele.nom')
    			->where('modele.type = :type')
    			->andWhere('modele.cylindre = :cylindre')
    			->andWhere('modele.constructeur = :constructeur')
    			->setParameter('type', $type)
    			->setParameter('cylindre', $cylindre)
    			->setParameter('constructeur', $constructeur)
    			->getQuery()
    			->getResult();
    			
    			return new JsonResponse($modeles);
    		}
    		else
    		{
    			$modeles = $em->getRepository("VPMVehiculeBundle:Modele")->findAll();
    			$array = array();
    			foreach ($modeles as $modele)
    			{
    				$array[] = array("nom"=>$modele->getNom(),"id"=>$modele->getId());
    			}
    			return new JsonResponse($array);
    		}
    	}
    }

    public function anneeAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	if ($request->isXmlHttpRequest()){
    		$array = array();
    		if ($request->get("type",null) && $request->get("marque",null) && $request->get("cylindre",null) && $request->get("modele",null))
    		{
    			$type = $em->getRepository("VPMVehiculeBundle:TypeVehicule")->find($request->get("type"));
    			$cylindre = $em->getRepository("VPMVehiculeBundle:Cylindre")->find($request->get("cylindre"));
    			$constructeur = $em->getRepository("VPMVehiculeBundle:Constructeur")->find($request->get("marque"));
    			$modeles = $em->getRepository("VPMVehiculeBundle:Modele")->findBy(
    					array("cylindre" => $cylindre, "type"=>$type, "constructeur" => $constructeur )
    					);
    	
    			$modeles = $em->getRepository("VPMVehiculeBundle:Modele")
    			->createQueryBuilder('modele')
    			->select('modele')
    			->where('modele.type = :type')
    			->andWhere('modele.cylindre = :cylindre')
    			->andWhere('modele.constructeur = :constructeur')
    			->andWhere('modele.nom = :nom')
    			->setParameter('type', $type)
    			->setParameter('cylindre', $cylindre)
    			->setParameter('constructeur', $constructeur)
    			->setParameter('nom', $request->get("modele"))
    			->getQuery()
    			->getResult();
    			
    			foreach ($modeles as $modele)
    			{
    				$array[] = array("annee" => $modele->getAnnee()->getAnnee(), "id" => $modele->getAnnee()->getId());
    			}
    			 
    			return new JsonResponse($array);
    		}
    		else
    		{
    			$annees = $em->getRepository("VPMVehiculeBundle:Annee")->findAll();
    			
    			foreach ($annees as $annee)
    			{
    				$array[] = array("annee"=>$annee->getAnnee(),"id"=>$annee->getId());
    			}
    			return new JsonResponse($array);
    		}
    	}
    }
    
    public function selectionAction(Request $request)
    {
    	if ($request->isXmlHttpRequest())
    	{
    		if ($request->get("annee",null) && $request->get("type",null) && $request->get("cylindre",null) && $request->get("modele",null) && $request->get("marque",null))
    		{
    			$em = $this->getDoctrine()->getManager();
    			
    			$annee = $em->getRepository("VPMVehiculeBundle:Annee")->find($request->get("annee"));
    			$cylindre = $em->getRepository("VPMVehiculeBundle:Cylindre")->find($request->get("cylindre"));
    			$constructeur = $em->getRepository("VPMVehiculeBundle:Constructeur")->find($request->get("marque"));
    			
    			$modele = $em->getRepository("VPMVehiculeBundle:Modele")->findOneBy(
    					array(
    							"annee" => $annee, 
    							"cylindre" => $cylindre,
    							"constructeur" => $constructeur,
    							"nom" => $request->get("modele")
    					));
 
    			$resposne = new Response("",Response::HTTP_OK);
    			$cookie = new Cookie("modeleVehicule",$modele->getId(),time() + 3600 * 7);
    			$resposne->headers->setCookie($cookie);
    			return $resposne;
    		}
    		else
    		{
    			return new Response("",Response::HTTP_BAD_REQUEST);
    		}
    		$em = $this->getDoctrine()->getManager();
    		
    	}
    	else
    	{
    		return new Response("",Response::HTTP_FORBIDDEN);
    	}
    }

}
