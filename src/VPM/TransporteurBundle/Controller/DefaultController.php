<?php

namespace VPM\TransporteurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VPMTransporteurBundle:Default:index.html.twig');
    }
}
