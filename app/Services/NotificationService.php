<?php

namespace App\Services;

use App\Models\EmailNotifications;
use App\Models\SmsNotifications;

class NotificationService
{
    public static function sendOtp($recipient)
    {
        $OTP_SENDER = env('OTP_SENDER');
        if ($OTP_SENDER == "sms") {
            $template =  SmsNotifications::where('type', 'otp')
                ->organization($recipient->organization_id)->first();
            $sender = new SmsSender($recipient, $template);
        } elseif ($OTP_SENDER == "email") {
            $template =  EmailNotifications::where('template_reference', 'otp')
                ->organization($recipient->organization_id)->first();
            $sender = new EmailSender($recipient, $template);
        }

        $sender->send($recipient, $template);
    }
}
