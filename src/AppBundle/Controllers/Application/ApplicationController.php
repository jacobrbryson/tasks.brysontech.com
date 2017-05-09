<?php

namespace AppBundle\Controllers\Application;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ApplicationController extends Controller{
    /**
     * @Route("/application", name="application")
     */
    public function applicationAction(Request $request)
    {
        return $this->render('Application/Index/index.html.twig');
    }
}