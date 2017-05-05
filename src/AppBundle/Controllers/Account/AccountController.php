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
    protected $em;
    
    public function __construct(){
        $this->em = $this->getDoctrine()->getManager();        
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
            $this->registerNewUser();
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
    
    /**
     * @Route("/resend", name="resend")
     */
    public function resendAction(Request $request)
    {
        
    }
    
    private function registerNewUser($email){
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
        $exists = $this->em->getRepository('AppBundle:User')
            ->findOneBy(array('email' => $email));
        return !$exists ? false : true;
    }
    
    private function verifyPasswords($password1, $password2){
        return $password1 === $password2;
    }
    
    private function sendConfirmEmail($email, $additional){
        $message = \Swift_Message::newInstance()
        ->setSubject('Confirmation Email')
        ->setFrom('task.admin@brysontech.com')
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
