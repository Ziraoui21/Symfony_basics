<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    
    #[Route('/mail', name: 'app_mail')]
    public function send(MailerInterface $mailer)
    {
        $email = (new Email())
        ->from('mailtrap@example.com')
        ->to('mailtrap@example.com')
        ->subject('Time for Symfony Mailer!')
        ->text('Sending emails is fun again!')
        ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

        return $this->json(true);
    }
}
