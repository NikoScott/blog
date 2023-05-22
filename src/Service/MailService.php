<?php

namespace App\Service;

use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailService {

    private $mailer;
    public function __construct(MailerInterface $mailer) {

        $this->mailer = $mailer;
    }
    
    public function sendMail($data, $to, $subject, $template) {

        $contact = new Contact();

        // Envoie de mail 
        $email = (new TemplatedEmail())
        ->from('contact@contact.fr')
        //    $this->getParameter('app.mail_address'))
        ->to(new Address($to))
        ->subject($subject)

        // path of the Twig template to render
        ->htmlTemplate($template)
        ->context($data);
        
        $this->mailer->send($email);
        
    }

}