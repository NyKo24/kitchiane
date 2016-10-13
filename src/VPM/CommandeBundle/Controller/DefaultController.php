<?php

namespace VPM\CommandeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VPMCommandeBundle:Default:index.html.twig');
    }
}
