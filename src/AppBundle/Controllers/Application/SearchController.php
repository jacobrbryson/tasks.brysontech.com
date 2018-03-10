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
            SELECT id, description, from_unixtime(created, '%Y-%m-%d %h:%i') as 'created', 
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
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("
            SELECT *
            FROM tasks
            WHERE id=:id
            LIMIT 1");
        $statement->bindValue('id', $task_id);
        
        $statement->execute();
        $results = $statement->fetchAll();
        
        return $this->render('Application/Search/searchresults.html.twig',[
            'results'=>$results[0]
        ]);
    }
}