<?php

namespace VPM\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('VPMImageBundle:Default:index.html.twig');
    }
}
