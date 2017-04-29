<?php

namespace AppBundle\Controllers\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SetupController extends Controller
{
    /**
     * @Route("/build", name="build")
     */
    public function buildAction(Request $request)
    {
        $results = $this->buildTables();
        return $this->render('setup/build.html.twig',['results' => $results]);
    }
    private function buildTables(){
        $kernel = $this->get('kernel');
        $application = new \Symfony\Bundle\FrameworkBundle\Console\Application($kernel);
        $application->setAutoExit(false);
        //Create de Schema 
        $options = array('command' => 'doctrine:schema:update',"--force" => true);
        $results = $application->run(new \Symfony\Component\Console\Input\ArrayInput($options));
        return $results;
    }
}
    