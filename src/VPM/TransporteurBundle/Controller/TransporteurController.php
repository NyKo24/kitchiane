<?php

namespace VPM\TransporteurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VPM\TransporteurBundle\Entity\Transporteur;
use Symfony\Component\HttpFoundation\Response;

class TransporteurController extends Controller
{
	protected $em;
	public function __construct($em = null)
	{
		if (is_null($em))
		{
			$em = $this->getDoctrine()->getEntityManager();
		}
		$this->em = $em;
	}
	
    
    
    
     
}
