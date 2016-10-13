<?php

namespace VPM\VehiculeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class TypeVehiculeController extends Controller
{
    public function listeAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	if ($request->isXmlHttpRequest()){
    		$constructeurs = $em->getRepository("VPMVehiculeBundle:TypeVehicule")->findAll();
    		$array = array();
    		foreach ($constructeurs as $constructeur)
    		{
    			$array[] = array("id"=>$constructeur->getId(),"nom"=>$constructeur->getNom());
    		}
    		return new JsonResponse($array);
    	}
    }

}
