<?php

namespace App\Service\Notification;

interface SmsSenderInterface
{
    public function sendSms(string $mobileNumber, string $message): void;
}
