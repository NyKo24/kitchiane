<?php
namespace VPM\UtilisateurBundle\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\au;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Response;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{   
    protected $router;
    protected $security;

    public function __construct(Router $router)
    {
        $this->router   = $router;
    }
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {   
    	return new Response("toto");
    } 
}