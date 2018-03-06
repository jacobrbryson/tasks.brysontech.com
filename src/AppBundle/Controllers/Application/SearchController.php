<?php

namespace AppBundle\Controllers\Application;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller{
    /**
     * @Route("/application/search", name="search")
     * @Method("POST")
     */
    public function search(){
        $wordsToSearch = $_POST['search'];

        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("
            SELECT id, description 
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
}