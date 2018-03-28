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

        $connection = $em->getConnection();
        $statement = $connection->prepare("
            SELECT DISTINCT(t.category_id) as 'category', c.name as 'name' 
            FROM tasks t 
            JOIN categories c ON t.category_id = c.id 
            WHERE owner = :owner 
            AND complete = 0 
            ORDER BY category_id asc");
        $statement->bindValue('owner', $this->getUser()->getId());
        $statement->execute();
        $distictCategories = $statement->fetchAll();

        $tasks = Array();
        $task = Array();

        if(!empty($distictCategories)){
            //loop over them to create the tasks array
            foreach($distictCategories as $category){
                $task['category']   = $category['name'];
                $task['id']         = $category['category'];
                $task['tasks']      = $em->getRepository('AppBundle:Tasks')
                ->findBy(array(
                    'owner' => $this->getUser()->getId(),
                    'complete' => 0,
                    'categoryId' => $category['category']
                ));
                $tasks[] = $task;
            }
        }else{
            $task['category']   = "Default";
            $task['id']         = "1";
            $task['tasks']      = $em->getRepository('AppBundle:Tasks')
            ->findBy(array(
                'owner' => $this->getUser()->getId(),
                'complete' => 0
            ));
            $tasks[] = $task;
        }
        
        return $tasks;
    }   
    
    /**
     * @Route("/tasks/add", name="/tasks/add")
     * @Method("POST")
     */
    public function addTask(){
        $taskData = array();
        parse_str($_POST['data'], $taskData);     
        $userId = $this->getUser()->getId();
        $results = Array(
            'result' => 0,
            'message' => "No userid or data."
        );

        //Check for UserId and data
        if (!$userId || empty($taskData)){
            return new Response(json_encode($results));
        }

        $em = $this->getDoctrine()->getManager();
        $task = new Tasks();
        
        $task->setDescription($taskData['description'])
            ->setSolution($taskData['solution'])
            ->setStartDateTime($taskData['start_date_time'])
            ->setEndDateTime($taskData['end_date_time'])
            ->setValue(0)
            ->setComplete(0)
            ->setOwner($userId)
            ->setCreated(time())
            ->setUpdated(time())
            ->setCategoryId($taskData['category']);
        
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
        $results = Array(
            'result' => 0, 
            'message' => "You're not authorized to modify this task."
        );
        
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
     * @Route("/search", name="/search")
     * @Method("POST")
     */
    public function searchTasks(){
        $search = $_POST['search'];         
        $em=$this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement=$connection->prepare(""
                . "SELECT * "
                . "FROM tasks "
                . "WHERE owner = :user_id AND description LIKE :search");
        
        $statement->bindValue('user_id', $this->getUser()->getId());
        $statement->bindValue('search', '%' . $search . '%');
        $statement->execute();
        
        return new Response(json_encode($this->getUser()->getId()));
    }
    
    /**
     * @Route("/application/step/add", name="/application/step/add")
     * @Method("POST")
     */
    public function addStep(){ 
        
        $em=$this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement=$connection->prepare("INSERT INTO task_steps (owner, task_id, complete, created, updated,"
                . " start_date_time, end_date_time, step_description)"
                . "VALUES (:owner, :task_id, 0, 1, 2, 3, 4, :step)");
        $statement->bindValue('owner', $this->getUser()->getId());
        $statement->bindValue('task_id', $_POST['task_id']);        
        $statement->bindValue('step', $_POST['step']);
        
        $statement->execute();
        
        $step_results = $connection->lastInsertId();
        
        return new Response(json_encode($step_results));
        
        /*for the "step_id" variable, I feel like I should be able to do something similar to what we do when I want to
         * get the "user_id" (see below).  However, I feel like that should be an "entity" type thing.  Is this
         * correct?  Ex.  Make an entity (i.e. "Steps.php") with "getters and setters" 
         * (specifically a set and get "id" so I can do a "$statement->bindValue('id', $this->getSteps()->getId());" 
         
        $step_id=24;
        $statement=$connection->prepare("
                SELECT
                    id,
                    owner,
                    task_id,
                    complete,
                    created,
                    updated,
                    start_date_time,
                    end_date_time,
                    step_description
                FROM task_steps
                WHERE id = :id
                AND owner = :user_id");
        $statement->bindValue('id', $step_id);
        $statement->bindValue('user_id', $this->getUser()->getId());
        $statement->execute();
        $step_results=$statement->fetchAll();
        
        /*If this is turning my "step_results" into a string and my step.js ajax is using the "response"
         * to return the console log of the information.  This makes sense to me.  But I still can't 
         * figure out how I can make the "step_results" variable "accessible" so I don't the get 
         * "step_results variable doesn't exist" error.
         
        return new Response(json_encode($step_results));*/
    }
}

