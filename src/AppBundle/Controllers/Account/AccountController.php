<?php

namespace AppBundle\Controllers\Account;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AccountController extends Controller{    
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('Web/Account/Login/index.html.twig',[
            'error'         => $error,
            'lastUsername'  => $lastUsername
        ]);
    }
    
    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $email      = isset($_POST['email'])    ? $_POST['email'] : false;
        $password1  = isset($_POST['password1']) ? $_POST['password1'] : false;
        $password2  = isset($_POST['password2']) ? $_POST['password2'] : false;
        $error      = false;
        
        $url = 'Web/Account/Register/index.html.twig';
        
        if($request->isMethod('POST') && validateRegistrationInformation($email, $password1, $password2)){
            //register the USER HERE!!!
            $url = 'Web/Account/Register/success.html.twig';
        } else if($request->isMethod('POST') && !validateRegistrationInformation($email, $password1, $password2)) {
            $error = "Email already exists within our system.<br/><a href='/resend'>Click Here to reset your password</a>";
        }
        
        return $this->render($url, [
            'error'     => $error,
            'email'     => $email
        ]);
        
    }
    
    /**
     * @Route("/account", name="account")
     */
    public function accountAction(Request $request)
    {
        
    }
    
    private function validateRegistrationInformation($email, $password1, $password2){
        return $this->sanitizeEmail($email) && 
            !$this->checkUserExists($email) && 
            $this->verifyPasswords($password1, $password2);
    }
    
    private function sanitizeEmail($email){      
        return !filter_var($email, FILTER_VALIDATE_EMAIL) === false ? $email : false;
    }
    
    private function checkUserExists($email){
        $em = $this->getDoctrine()->getManager();
        $exists = $em->getRepository('AppBundle:User')
            ->findOneBy(array('email' => $email));
        return !$exists ? false : true;
    }
    
    private function verifyPasswords($password1, $password2){
        return $password1 === $password2;
    }
}
