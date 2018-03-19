<?php 

namespace AppBundle\Controllers\Application;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StatsController extends Controller{
    /**
     * @Route("/application/stats/completedByCategory", name="completedByCategory")
     * @Method("POST")
     */
    public function completedTaskCountByCategory(){
        $sevenDaysAgo = time() - 604800; //7 days
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $sqlstring = "SELECT ij.total, c.Name
        FROM categories c
        JOIN (SELECT count(t.id) as 'total', t.category_id 
            FROM tasks t
            WHERE t.complete = 1
            AND t.updated > :sevenDaysAgo
            AND t.owner = :user_id 
            GROUP BY t.category_id) ij
        ON c.id = ij.category_id";
        $statement = $connection->prepare($sqlstring);

        $statement->bindValue('sevenDaysAgo', $sevenDaysAgo);
        $statement->bindValue('user_id', $this->getUser()->getId());
        
        $statement->execute();
        $results = $statement->fetchAll();
        
        return new Response(json_encode($results));
    }
}