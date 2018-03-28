<?php

namespace AppBundle\Controllers\Application;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller{
    /**
     * @Route("/application/search", name="search1")
     * @Method("POST")
     */
    public function search(){
        $wordsToSearch = $_POST['search'];

        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("
            SELECT id, description, solution, from_unixtime(created, '%Y-%m-%d %h:%i') as 'created', 
            from_unixtime(updated, '%Y-%m-%d %h:%i') as 'updated', complete  
            FROM tasks
            WHERE description LIKE :search 
            AND owner = " . $this->getUser()->getId()
        );
        $statement->bindValue('search', '%' . $wordsToSearch . '%');
        
        $statement->execute();
        $results = $statement->fetchAll();

        return $this->render('Application/Search/index.html.twig',[
            'results' => $results
        ]);
    }
    
    /**
     * @Route("/application/task/{task_id}", name="/task/{task_id}")
     */
    public function taskAction($task_id){
        function getSteps($task_id){};
        $steps=$this->getSteps($task_id);
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("
        SELECT 
            t.id, 
            t.description,
            t.solution,
            from_unixtime(t.created, '%Y-%m-%d %h:%i') as 'created', 
            from_unixtime(t.updated, '%Y-%m-%d %h:%i') as 'updated', 
            from_unixtime(t.start_date_time, '%Y-%m-%d %h:%i') as 'start_date_time', 
            from_unixtime(t.end_date_time, '%Y-%m-%d %h:%i') as 'end_date_time',
            complete,
            c.name
        FROM tasks t
        JOIN categories c
        ON t.category_id = c.id
        WHERE t.id = :id
        AND owner = :user_id
        LIMIT 1");
        $statement->bindValue('id', $task_id);
        $statement->bindValue('user_id', $this->getUser()->getId());
        
        $statement->execute();
        $results = $statement->fetchAll();
        if(empty($results)){
            return $this->redirectToRoute('application');
        } else {
            return $this->render('Application/Task/index.html.twig',[
                'results'=>$results[0], 'steps'=>$steps
            ]);
        }
    }
}