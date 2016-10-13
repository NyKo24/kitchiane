<?php

namespace VPM\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VPMAdminBundle:Default:index.html.twig');
    }
}
