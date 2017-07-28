<?php

namespace AppBundle\Controllers\Application;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\Tasks;
use AppBundle\Entity\TasksPoints;

class ApplicationController extends Controller{
    /**
     * @Route("/application", name="application")
     */
    public function applicationAction(Request $request)
    {
        return $this->render('Application/Index/index.html.twig',
                [
                    'tasks' => $this->getIncompleteTasksByUser()
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
            //*...*// }
        }
    
}

