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
        return $this->render('Application/Settings/index.html.twig',[
            'categories' => $this->getCategory()
        ]);
    }
    
    function getCategory($all = false, $id = 1){
            //set variable "categories" to an empty array; setting aside memory
            $categories= array();
            //this tells the site to "try" this aspect of the function
            try{
                //establish the connection to our database
                $em = $this->getDoctrine()->getManager();
                //have "categories" go to the AppBundle/Entity/Category.php for the "Category" class
                $categories = $em->getRepository('AppBundle:Category')
            ->FindBy(['userId' => $this->getUser()->getId()]);
                //if the "try" doesn't work, then this will activate//
            } catch (Exception $ex) {

            }
            //return the results of our variables categories 
            return $categories;
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
        
        public function deleteCategory(){
            $categoryId = isset($_POST['category_id']) ? $_POST['category_id'] : false;
                    
            try{
                //initializes the database connection
                $em = $this->getDoctrine()->getManager();
                //initializes the $removeThisCategory to go to the Category repository and find a category by 
                //its id.
                $removeThisCategory = $em->getRepository('AppBundle:Category')
                     ->findOneBy(array('id' => $categoryId));
                
                //tells our database to remove the named category and to apply the changes 
                $em->remove($removeThisCategory);
                $em->flush();
                
                
            } catch (Exception $ex) {

            }
            
        }
}