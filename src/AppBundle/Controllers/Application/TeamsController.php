<?php

namespace AppBundle\Controllers\Application;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TeamsController extends Controller{
    /**
     * @Route("/application/teams/get", name="/application/teams/get")
     * @Method("POST")
     */
    public function getTeams(){
        $results = Array(
            'result'    => 0,
            'message'   => 'no message.',
            'data'      => Array(
                Array('id' => 1,
                    'name'  => 'test')
            )
        );//Essentially an empty response...
        
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("SELECT c.id, c.name FROM teams c JOIN user_teams uc ON c.id = uc.teamId WHERE uc.userID = " . $this->getUser()->getId());
        $statement->execute();
        $results['data'] = $statement->fetchAll();
        
        return new Response(json_encode($results));
    }
    
    /**
     * @Route("/application/teams/add", name="/application/teams/add")
     * @Method("POST")
     */
    public function addCategory(){
        $results = Array(
            'result'    => 0,
            'message'   => 'no message.',
            'data'      => Array(
                Array('id' => 1,
                    'name'  => 'test')
            )
        );//Essentially an empty response...
        
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("INSERT INTO teams (name) VALUES (:name)");
        $statement->bindValue('name', $_POST['name']);
        $statement->execute();
        
        $insertId = $connection->lastInsertId();
        
        $statement = $connection->prepare("INSERT INTO user_teams (userId, teamId) VALUES (" . $this->getUser()->getId() . ", " . $insertId . ")");
        $statement->execute();
        
        $statement = $connection->prepare("SELECT c.id, c.name FROM teams c JOIN user_teams uc ON c.id = uc.teamId WHERE c.id = " . $insertId);
        $statement->execute();
        
        $results['data'] = $statement->fetchAll();
        
        return new Response(json_encode($results));
    }
}