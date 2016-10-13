<?php

namespace VPM\UtilisateurBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class VPMUtilisateurBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
