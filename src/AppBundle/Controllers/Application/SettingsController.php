<?php

namespace AppBundle\Controllers\Application;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SettingsController extends Controller{
    /**
     * @Route("/application/settings", name="settings")
     */
    public function settingsAction()
    {
        return $this->render('Application/Settings/index.html.twig');
    }
}