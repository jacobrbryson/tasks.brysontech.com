<?php

namespace AppBundle\Controllers\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller{
    /**
     * @Route("/admin", name="admin")
     */
    public function adminAction(Request $request)
    {
        return $this->render('Admin/Index/index.html.twig',
                [
                    'emails' => $this->getEmails()
                ]);
    }
    
    private function getEmails(){
        $emails = Array(
            Array(
                'id' => 0,
                'name' => "Select Email"
            )
        );
        
        return $emails;
    }
    
    /**
     * @Route ("/admin/users", name="users")
     */
    public function adminUsersAction(Request $request)
    {
        return $this->render('Admin/Users/index.html.twig');
    }
}