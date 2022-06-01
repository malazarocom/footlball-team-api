<?php

namespace App\Service\Notification\Channels\Mail;

use App\Entity\Player;
use App\Entity\Trainer;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use App\Service\Notification\MailerServiceInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class Mailer implements MailerServiceInterface
{
    public function __construct(
        private MailerInterface $mailer
    ) {
    }

    public function getMailer(): MailerInterface
    {
        return $this->mailer;
    }

    public function setMailer(MailerInterface $mailer): void
    {
        $this->mailer = $mailer;
    }

    public function createNotification(
        Player|Trainer $member,
        string $actionType,
        string $from = 'test@test.com',
        string $to = 'test@test.com',
        string $subject = 'Notification subject on',
        string $text = 'Notification test',
    ) {
        $email = (new TemplatedEmail());
        $email->from($from);
        $email->to($to);
        $email->subject($subject);
        $email->text($text);
        $email->htmlTemplate('notification/emails/' . $this->getTemplate($member, $actionType))
            ->context([
                'member' => $member,
            ]);

        return $email;
    }

    public function getTemplate(Player|Trainer $member, string $actionType): string
    {
        $memberType = $member instanceof Player ? 'player' : 'trainer';

        return "{$memberType}.{$actionType}.html.twig";
    }

    public function sendEmail(Email $email): void
    {
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface) {
            // ...
        }
    }
}
