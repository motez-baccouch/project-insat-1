<?php


namespace App\Service;


use PhpParser\Node\Scalar\String_;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class Mailer
{

    private $mailer;

    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
    }

    public function  send(string $from, string $to, string $subject, string $body){
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->html($body);

        $this->mailer->send($email);
    }


}