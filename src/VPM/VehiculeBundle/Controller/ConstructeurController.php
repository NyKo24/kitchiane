<?php

namespace VPM\VehiculeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\ORM\Query\AST\WhereClause;
use ProxyManagerTestAsset\HydratedObject;
use Symfony\Component\HttpFoundation\Response;

class ConstructeurController extends Controller
{
    public function listeAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()){
         	if ($request->get("type",null)) // les marques d'un seul type
         	{
         		$constructeurs = $em->getRepository("VPMVehiculeBundle:TypeVehicule")
         		->find($request->get("type"))
         		->getConstructeur();
         	}
         	else // toutes les marques
         	{
         		$constructeurs = $em->getRepository("VPMVehiculeBundle:Constructeur")->findAll();
         	}
        	
        	$array = array();
        	foreach ($constructeurs as $constructeur)
        	{
        		$array[] = array("id"=>$constructeur->getId(),"nom"=>$constructeur->getNom());
        	}
        	return new JsonResponse($array);
        }
    }
    


}
