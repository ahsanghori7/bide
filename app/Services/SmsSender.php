<?php

namespace App\Services;

class SmsSender
{
    private $user = "";
    private $url = "";
    private $password = "";
    private $sender = "";
    private $response = "";
    private $key = "";

    public function __construct(private $recipient, private $template)
    {
        $this->recipient = $recipient;
        $this->template = $template;

        $this->url = env('SMS_URL');
        $this->user = env('SMS_USER');
        $this->password = env('SMS_PASSWORD');
        $this->sender = env('SMS_SENDER');
        $this->response = env('SMS_RESPONSE');
        $this->key = env('SMS_KEY');
    }

    public function send()
    {
        try {
            $to = $this->recipient->phone;
            $message = $this->template->content;
            $network = null;
            if ($this->template->type == 'otp') {
                $type = 'OTP';
            } else {
                $type = 'Default';
            }

            $to = "92" . substr($to, -10);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->url . 'send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
                        "to": "' . $to . '",
                        "from": "' . $this->sender . '",
                        "text": "' . $message . '",
                        "type": "' . $type . '"
                    }',
                CURLOPT_HTTPHEADER => array(
                    'x-api-key: ' . $this->key . '',
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
        } catch (\Exception $e) {
            return true;
        }
    }
}
