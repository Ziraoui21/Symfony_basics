<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
// add attachement for mail
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;

class MailController extends AbstractController
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    
    #[Route('/mail', name: 'app_mail')]
    public function send()
    {
        $email = (new Email())
        ->from('mailtrap@example.com')
        ->to('mailtrap@example.com')
        ->subject('Time for Symfony Mailer!')
        ->text('Sending emails is fun again!')
        ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($email);

        return $this->json(true);
    }

    #[Route('/mail/temp', name: 'app_mail')]
    public function email_twig(ProductRepository $repo,$publicDir)
    {
        $email = (new TemplatedEmail())
        ->from('fabien@example.com')
        ->to('zira@gmail.com')
        ->subject('Thanks for signing up!')
        // ->attachFromPath($publicDir.'public/images_profil/logo.png','test.png')
        ->attachFromPath($this->getParameter('publicDir').'public/images_profil/logo.png','test.png')
        // path of the Twig template to render
        ->htmlTemplate('mail/template.html.twig')
        // pass variables (name => value) to the template
        ->context([
            'product' => $repo->find(1)
        ]);

        $this->mailer->send($email);

        return $this->json(true);
    }
}
