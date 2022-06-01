<?php

namespace App\Service\Notification;

use Symfony\Component\Mime\Email;

interface MailerServiceInterface
{
    public function sendEmail(Email $email): void;
}
