<?php
namespace AppBundle\Controllers\Account;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class registrationController extends Controller{
    /**
     * @Route("/testregister")
     */
    public function indexAction()
    {
        $email = isset($_POST['email']) ? $_POST['email'] : false;
        $results = false;
        
        if($email){
            $results = $this->testEmailSystem($email);
        }
        return $this->render('Web/Account/Register/index.html.twig', [
            'results'   => $results
        ]);
    }
    
    private function testEmailSystem($email){
        $name = "Ross Bryson";
        $message = \Swift_Message::newInstance()
        ->setSubject('Hello Email')
        ->setFrom('ross@brysontech.com')
        ->setTo($email)
        ->setBody(
            $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                'Emails/registration.html.twig',
                array('name' => $name)
            ),
            'text/html'
        )
        /*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'Emails/registration.txt.twig',
                array('name' => $name)
            ),
            'text/plain'
        )
        */
    ;
    return "Number of emails sent: " . $this->get('mailer')->send($message);
    }
}
