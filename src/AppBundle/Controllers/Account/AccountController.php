<?php

namespace AppBundle\Controllers\Account;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use AppBundle\Entity\User;
use AppBundle\Entity\User_Details;

class AccountController extends Controller{    
    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $error = false;
        $url = 'Web/Account/Register/index.html.twig';
        
        if($request->isMethod('POST')){
            $email      = isset($_POST['email'])    ? $_POST['email'] : false;
            $password1  = isset($_POST['password1']) ? $_POST['password1'] : false;
            $password2  = isset($_POST['password2']) ? $_POST['password2'] : false;
            
            if($this->validateRegistrationInformation($email, $password1, $password2)){
                $this->registerNewUser($email, $password1);
                $url = 'Web/Account/Register/success.html.twig';
            } else {
                $error = "Invalid registration, please check that your passwords "
                    . "match and that you do not already have an account.";
            }
        } else {
            $email = isset($_GET['email']) ? $_GET['email'] : false;
            $token = isset($_GET['token']) ? $_GET['token'] : false;
            
            if ($email && $token){
                if($this->enableUser($email, $token)){
                    return $this->redirectToRoute('application');
                } else {
                    $error = "Something went wrong when enabling your account. "
                        . "Double check the URL that was sent to you and that you "
                        . "did not register more than 24 hours ago. You can have "
                        . "the email resent HERE or contact support at admin@brysontech.com";
                }
            }
        }
        
        return $this->render($url, [
            'error'     => $error,
            'email'     => $email
        ]);
        
    }
    
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
     * @Route("/resend", name="resend")
     */
    public function resendAction(Request $request)
    {
        
    }
    
    private function enableUser($email, $token){
        if($this->sanitizeEmail($email)){
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('AppBundle:User')
            ->findOneBy(array('email' => $email));
            
            if($user->getConfirmationToken() === $token){
                $user->setEnabled(1)
                    ->addRole("ROLE_USER")
                    ->setRoles(array("ROLE_USER"));
                $em->persist($user);
                $em->flush();
                
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);
                $this->get('session')->set('_security_main', serialize($token));
                return true;
            }
        }
        
        return false;
    }
    
    private function registerNewUser($email, $pw){
        $user           = new User();
        $userDetails    = new User_Details();
        $password       = $this->get('security.password_encoder')->encodePassword($user, $pw);
        $tokenGenerator = $this->container->get('fos_user.util.token_generator');
        $expirationTime = new \DateTime();
        $expirationTime->setTimestamp(time() + 3600);

        $user->setPassword($password)
            ->setUserName($email)
            ->setEmail($email)
            ->setConfirmationToken($tokenGenerator->generateToken());

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $userDetails->setId($user->getId());
        $userDetails->setFirstName('New-' . $user->getId());
        $userDetails->setMiddleName('Awesome');
        $userDetails->setLastName('User');
        $userDetails->setBirthday(0);
        $em->persist($userDetails);
        $em->flush();

        $additional['token'] = $user->getConfirmationToken();

        $this->sendConfirmEmail($email, $additional);
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
        return empty($exists) ? false : true;
    }
    
    private function verifyPasswords($password1, $password2){
        return $password1 === $password2 ? true : false;
    }
    
    private function sendConfirmEmail($email, $additional){
        $message = \Swift_Message::newInstance()
        ->setSubject('Tasks Manager - Confirmation Email')
        ->setFrom('admin@brysontech.com')
        ->setTo($email)
        ->setBody(
            $this->renderView(
                'Emails/registration.html.twig',
                array('email' => $email,
                    'additional' => $additional,)
            ),
            'text/html'
        )->addPart(
            $this->renderView(
                'Emails/registration.txt.twig',
                array('email' => $email,
                'additional' => $additional,)
            ),
            'text/plain'
        );
        
        $this->get('mailer')->send($message);
    }
}