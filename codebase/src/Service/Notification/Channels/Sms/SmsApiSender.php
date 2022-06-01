<?php

namespace App\Service\Notification\Channels\Sms;

// use Smsapi\Client\SmsapiHttpClient;
// use Smsapi\Client\Feature\Sms\Bag\SendSmsBag;
use App\Service\Notification\SmsSenderInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class SmsApiSender implements SmsSenderInterface
{
    /**
     * SMSAPI.COM client
     */
    // SmsapiHttpClient protected $smsApi;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $apiToken = $parameterBag->get('sms_api_token');
        // $this->smsApi = (new SmsapiHttpClient())
        //     ->smsapiComService($apiToken);
    }

    public function sendSms(string $mobileNumber, string $message): void
    {
        // $sms = SendSmsBag::withMessage($mobileNumber, $message);
        // Disabled due to authorization failure - account not registered
        // $this->smsApi->smsFeature()->sendSms($sms);
    }
}
