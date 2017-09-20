<?php

namespace AppBundle\Controllers\Application;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Category;

class SettingsController extends Controller{
    /**
     * @Route("/application/settings", name="settings")
     */
    public function settingsAction()
    {
        return $this->render('Application/Settings/index.html.twig');
    }
    
    /**
        * @Route("/tasks/addCategory", name="/tasks/addCategory")
        * @Method("POST")
        */
        public function addCategory(){
            $name  = isset($_POST['name']) ? $_POST['name'] : false;            
            $userId = $this->getUser()->getId();
            try{
                $em = $this->getDoctrine()->getManager();
                $newcategories = new Category();
                
                $newcategories->setName($name)
                              ->setUserId($userId);
                
                $em->persist($newcategories);
                $em->flush();
                
            } catch (Exception $ex) {

            }
            return new Response(json_encode("Added"));
        }
}