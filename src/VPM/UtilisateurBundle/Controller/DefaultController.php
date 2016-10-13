<?php

namespace VPM\UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VPMUtilisateurBundle:Default:index.html.twig');
    }
}
