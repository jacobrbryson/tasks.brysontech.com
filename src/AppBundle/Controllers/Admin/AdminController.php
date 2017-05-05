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
        
    }
}