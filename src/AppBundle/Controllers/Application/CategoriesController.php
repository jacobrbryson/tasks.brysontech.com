<?php

namespace AppBundle\Controllers\Application;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoriesController extends Controller{
    /**
     * @Route("/application/categories/get", name="/application/categories/get")
     * @Method("POST")
     */
    public function getCategories(){
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
        $statement = $connection->prepare("SELECT c.id, c.name FROM categories c JOIN user_categories uc ON c.id = uc.category_id WHERE uc.userID = " . $this->getUser()->getId());
        $statement->execute();
        $results['data'] = $statement->fetchAll();
        
        return new Response(json_encode($results));
    }
    
    /**
     * @Route("/application/categories/add", name="/application/categories/add")
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
        $statement = $connection->prepare("INSERT INTO categories (name, description) VALUES (:name, '')");
        $statement->bindValue('name', $_POST['name']);
        $statement->execute();
        
        $insertId = $connection->lastInsertId();
        
        $statement = $connection->prepare("SELECT c.id, c.name FROM categories c JOIN user_categories uc ON c.id = uc.category_id WHERE c.id = " . $insertId);
        $statement->execute();
        
        $results['data'] = $statement->fetchAll();
        
        return new Response(json_encode($results));
    }
 
   
    /**
     * @Route ("/application/categories/update", name="/application/categories/update")
     * @Method("POST")
     */
    public function updateCategory(){
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection(); 
        $statement = $connection->prepare(
            "UPDATE categories "
            . "SET name=:name "
            . "WHERE id=:id"
        );       
        $statement->bindValue('id', $_POST['id']);
        $statement->bindValue('name', $_POST['new_name']);
        $statement->execute();
       
        return new Response(json_encode($connection->lastInsertId()));
    }
    
     /**
     * @Route ("/application/categories/delete", name="/application/categories/delete")
     * @Method("POST")
     */
    
    public function deleteCategory(){
        $em=$this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement=$connection->prepare("DELETE FROM categories WHERE id=:id");
        $statement->bindValue('id', $_POST['id']);
        $statement->execute();
        
        return new Response(json_encode($connection->lastInsertId()));
    }
    
}