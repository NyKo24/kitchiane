<?php

namespace VPM\VehiculeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use VPM\VehiculeBundle\Entity\TypeVehicule;

class CylindreController extends Controller
{
    public function listeAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	if ($request->isXmlHttpRequest()){

    		if ($request->get("type",null) && $request->get("marque",null))
    		{
    			$type = $em->getRepository("VPMVehiculeBundle:TypeVehicule")->find($request->get("type"));
    			$resultCylindre = $em->getRepository("VPMVehiculeBundle:Cylindre")->findBy(
    					array("constructeur" => $request->get("marque"))
    					);
    			
    			foreach ($resultCylindre as $cylindre)
    			{
    				if ($cylindre->getConstructeur()->getType()->contains($type) )
    				{
    					$cylindres[] = $cylindre;
    				}
    			}
    		}
    		else
    		{
    			$cylindres = $em->getRepository("VPMVehiculeBundle:Cylindre")->findAll();
    		}
    		$array = array();
    		foreach ($cylindres as $cylindre)
    		{
    			$array[] = array("id"=>$cylindre->getId(),"taille"=>$cylindre->getTaille());
    		}
    		return new JsonResponse($array);
    	}
    }

}
