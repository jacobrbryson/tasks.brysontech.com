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
        $statement = $connection->prepare("
            SELECT id, name 
            FROM categories 
            WHERE user_id = " . $this->getUser()->getId()
        );
        $statement->execute();
        $results['data'] = $statement->fetchAll();
        
        return new Response(json_encode($results));
    }
    
    /**
     * @Route("/application/categories/add", name="/application/categories/add")
     * @Method("POST")
     */
    public function addCategory(){
        $result = 0;
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("
            INSERT INTO categories (user_id, name, description) 
            VALUES (:user_id, :name, '')
        ");
        $statement->bindValue('name', $_POST['name']);
        $statement->bindValue('user_id', $this->getUser()->getId());
        $statement->execute();
        
        $result = $connection->lastInsertId();
        
        return new Response(json_encode($result));
    }
 
   
    /**
     * @Route ("/application/categories/update", name="/application/categories/update")
     * @Method("POST")
     */
    public function updateCategory(){
        $result = 0;
        categoryId = $_POST['id'];
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection(); 
        $statement = $connection->prepare("
            UPDATE categories
            SET name=:name
            WHERE id=:id
        ");       
        $statement->bindValue('id', categoryId);
        $statement->bindValue('name', $_POST['new_name']);
        $statement->execute();
       
        $result = categoryId;
        
        return new Response(json_encode($result));
    }
    
     /**
     * @Route ("/application/categories/delete", name="/application/categories/delete")
     * @Method("POST")
     */
    
    public function deleteCategory(){
        $result = 0;
        categoryId = $_POST['id'];
        $em=$this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement=$connection->prepare("
            UPDATE tasks 
            SET category_id = 1 
            WHERE category_id = :id;
            DELETE FROM categories 
            WHERE id=:id;
        ");
        $statement->bindValue('id', categoryId);
        $statement->execute();

        $result = categoryId;
        
        return new Response(json_encode($result));
    }
}