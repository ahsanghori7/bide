<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class EmailSender
{
    public function __construct(private $recipient, private $template)
    {
        $this->recipient = $recipient;
        $this->template = $template;
    }

    public function send()
    {
        try {
            $templateValue = $this->replaceContent($this->template);

            if (env('APP_ENV') == 'staging' || env('APP_ENV') == 'production') {
                $temp = array();
                $temp['subject'] = $this->template->subject;
                $to_email = $this->recipient->email;
                $subject = $this->template->subject;

                $temp['html'] = $templateValue;
                $temp['subject'] = $subject;
                Mail::send(
                    ['html' => $this->template->template_path],
                    $temp,
                    function ($message) use ($to_email, $subject) {
                        $message->to($to_email)
                            ->subject($subject)
                            ->from(env('MAIL_FROM_ADDRESS'));
                    }
                );
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function replaceContent($template)
    {
        preg_match_all('/\{([^}]+)\}/', $template->body, $matches);
        $placeholders = $matches[1];
        $explodeValue = explode('^', $template->body);
        $templateValue = null;
        foreach ($placeholders as $key => $placeholder) {
            if ($placeholder == 'name') {
                $templateValue .= str_replace(
                    '{' . $placeholder . '}',
                    isset($this->recipient) ? $this->recipient->name : 'Customer',
                    $explodeValue[$key]
                );
            } elseif ($placeholder == 'doctor_name') {
                $templateValue .= str_replace(
                    '{' . $placeholder . '}',
                    isset($this->recipient) ? $this->recipient->doctor->name : 'Doctor',
                    $explodeValue[$key]
                );
            } elseif ($placeholder == 'uan_number') {
                $templateValue .= str_replace('{' . $placeholder . '}', env('UAN_NUMBER'), $explodeValue[$key]);
            } elseif ($placeholder == 'date') {
                $templateValue .= str_replace(
                    '{' . $placeholder . '}',
                    Carbon::now()->format('Y-m-d'),
                    $explodeValue[$key]
                );
            } elseif ($placeholder == 'link') {
                $templateValue .= str_replace('{' . $placeholder . '}', env('WEB_URL'), $explodeValue[$key]);
            } elseif ($placeholder == 'otp') {
                $templateValue .= str_replace('{' . $placeholder . '}', $this->recipient->otp, $explodeValue[$key]);
            }
        }
        return $templateValue;
    }
}
