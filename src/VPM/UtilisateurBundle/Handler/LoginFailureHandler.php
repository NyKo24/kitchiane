<?php
namespace VPM\UtilisateurBundle\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class LoginFailureHandler extends DefaultAuthenticationFailureHandler
{

	protected $routeur; 
	
	public function __construct(Router $routeur)
	{
		$this->routeur = $routeur;	
	}
	
	public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
	{
		
		return new Response($request->isMethod("POST"));

	}

}