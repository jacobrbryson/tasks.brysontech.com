<?php

namespace AppBundle\Controllers\Application;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Tasks;
use AppBundle\Entity\Category;
use AppBundle\Entity\TasksPoints;

class ApplicationController extends Controller{
    /**
     * @Route("/application", name="application")
     */
    public function applicationAction(Request $request)
    {
        $this->addCategory("Put Your Name Here Justin");
        $this->deleteCategory("7");
        return $this->render('Application/Index/index.html.twig',
                [
                    'tasks' => $this->getIncompleteTasksByUser(),
                    'categories' => $this->getCategory()
                ]);
    }
    
    private function getIncompleteTasksByUser(){
        $em = $this->getDoctrine()->getManager();
        $tasks = $em->getRepository('AppBundle:Tasks')
            ->findBy(array('owner' => $this->getUser()->getId(), 'complete' => 0));
        
        return $tasks;
    }   
    
    /**
     * @Route("/tasks/addTask", name="/tasks/addTask")
     * @Method("POST")
     */
    public function addTask(){
        $taskData = array();
        parse_str($_POST['data'], $taskData);     
        $userId = $this->getUser()->getId();
        $results = Array('result' => 0, 'message' => "No userid or data.");

        //Check for UserId and data
        if (!$userId || empty($taskData)){
            return new Response(json_encode($results));
        }

        $em = $this->getDoctrine()->getManager();
        $task = new Tasks();
        
        $task->setDescription($taskData['description'])
            ->setStartDateTime($taskData['start_date_time'])
            ->setEndDateTime($taskData['end_date_time'])
            ->setValue(0)
            ->setComplete(0)
            ->setOwner($userId)
            ->setCreated(time())
            ->setUpdated(time());
        
        $em->persist($task);
        $em->flush();
                
        $results['result'] = 1;
        $results['task_id'] = $task->getId();
        
        return new Response(json_encode($results));
    }

    /**
     * @Route("/tasks/deleteTask", name="/tasks/deleteTask")
     * @Method("POST")
     */
    public function deleteTask(){
        //Initialize stuff we need
        $taskId  = isset($_POST['task_id']) ? $_POST['task_id'] : false;
        $userId = $this->getUser()->getId();
        $results = Array('result' => 0, 'message' => "You're not authorized to modify this task.");
        
        //Check for taskId
        if(!$taskId){
            return new Response(json_encode($results));
        }
        
        //Check for UserId
        if (!$userId){
            return new Response(json_encode($results));
        }
        
        //Get Doctrine ready for connections
        $em = $this->getDoctrine()->getManager();
        
        //check if user is the owner of the task, if yes, delete it and return results
        $task = $em->getRepository('AppBundle:Tasks')
                     ->findOneBy(array('id' => $taskId));
        
        $owner = !empty($task) && $task->getOwner() === $userId ? true : false;
        
        if($owner){
            $em->remove($task);
            $em->flush();
            
            $results['result'] = 1;
            $results['message'] = "Task deleted by task owner.";
            
            return new Response(json_encode($results));
        }
        
        //check if user is on a team, if no return results
        $team = $em->getRepository('AppBundle:TasksTeams')
                     ->findOneBy(array('userId' => $userId));
        
        if(empty($team)){
            return new Response(json_encode($results));
        }
        
        //check if task belongs to that team, if yes, delete and return results
        if($task->getTeam() === $team->getId()){
            $em->remove($task);
            $em->flush();
            
            $results['result'] = 1;
            $results['message'] = "Task deleted by team member.";
            
            return new Response(json_encode($results));
        }
        
        //last, return results
        return new Response(json_encode($results));
    }
    
    /**
     * @Route("/tasks/completeTask", name="/tasks/completeTask")
     * @Method("POST")
     */
    public function completeTask(){
        //Initialize stuff we need
        $taskId  = isset($_POST['task_id']) ? $_POST['task_id'] : false;
        $userId = $this->getUser()->getId();
        $results = Array('result' => 0, 'message' => "");
        
        //Check for taskId
        if(!$taskId){
            return new Response(json_encode($results));
        }
        
        //Check for UserId
        if (!$userId){
            return new Response(json_encode($results));
        }
        
        //Get Doctrine ready for connections
        $em = $this->getDoctrine()->getManager();
        
        //check if user is the owner of the task, if yes, delete it and return results
        $task = $em->getRepository('AppBundle:Tasks')
                     ->findOneBy(array('id' => $taskId));
        
        $owner = !empty($task) && $task->getOwner() === $userId ? true : false;

        if($owner){
            $task->setComplete(1)
                ->setUpdated(time());
            
            $em->persist($task);
            $em->flush();
                
            $results['result'] = 1;
            $results['message'] .= "Completed by owner.&nbsp;&nbsp;---&nbsp;&nbsp;<a href='/tasks/undo?action=complete&task_id=" . $taskId . "'>Undo</a>";
            
            return new Response(json_encode($results));
        }
        
        //last, return results
        return new Response(json_encode($results));
    }  
        /**
         * @Route("/application/teams", name="application/teams")
         */
        public function teamsAction(){
            
            return $this->render('Application/Teams/Index/index.html.twig');
        }
        
        /**
         * @Route("/application/teams/addteam", name="application/teams/addteam")
         */
        public function AddTeamAction(){
            $TeamName  = isset($_POST['TeamName']) ? $_POST['TeamName'] : false;
            
            return $this->render('Application/Teams/AddTeam.html.twig',
                    [
                        
                    'TeamName' => $TeamName
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
        
        function addCategory($name){
            $newcategories=array();
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
            
        }
        //the parameter used here will be the one used by the function to identify which category to delete
        public function deleteCategory($categoryId){
            
            //initialize stuff we need
                //this line retrieves the id of the current user
            $userId = $this->getUser() ->getId();
                //this line initializes $categoryId by using the getId function from the Category entity
            //$categoryId=$this->getId();
            try{
                //initializes the database connection
                $em = $this->getDoctrine()->getManager();
                //initializes the $removeThisCategory to go to the Category repository and find a category by 
                //its id.
                    //Question...is 'id' the way that $categoryId gets a value which in turn makes 
                    //$removeThisCategory have a value?
                $removeThisCategory = $em->getRepository('AppBundle:Category')
                     ->findOneBy(array('id' => $categoryId));
                
                //tells our database to remove the named category and to apply the changes 
                $em->remove($removeThisCategory);
                $em->flush();
                
                
            } catch (Exception $ex) {

            }
            
        }
    
}

