<?php

namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

/**
 *
 */
class MailerService
{

    /**
     * @param MailerInterface $mailer
     */
    public function __construct(private MailerInterface $mailer){}

    /**
     * @param $user
     * @param $info
     * @return void
     */
    public function SendMailFunc($user, $info):void
    {

        $email = (new TemplatedEmail())
            ->from('no-reply@acidShark.com')
            ->to($user['userEmail'])
            ->subject('Тестовий меіл !')
            ->htmlTemplate('mailTemplate.twig')
            ->context([
                'from' => $info['from'],
                'text' => $info['text'],
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            $e->getMessage();
        }
    }
}