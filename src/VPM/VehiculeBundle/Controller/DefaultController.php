<?php

namespace VPM\VehiculeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VPMVehiculeBundle:Default:index.html.twig');
    }
}
