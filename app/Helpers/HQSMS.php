<?php

namespace App\Helpers;

class HQSMS
{
                        //luka           cater          marko
    private $numbers = ['38640555922', '38651609658', '38641807670'];

    private $token = 'nkjjSvNPChgdS4SVOoyok5apulW2E5TSRFpzLllW';

    public function send_sms($message)
    {
        foreach ($this->numbers as $number) {
            $params = array(
                'to' => $number,
                'from' => 'RippleWise',
                'message' => $message,
            );
            $this->sms_send_oauth($params);
        }
    }

    private function sms_send_oauth($params, $backup = false)
    {
        static $content;
        if ($backup == true) {
            $url = 'https://api2.smsapi.com/sms.do';
        } else {
            $url = 'https://api.smsapi.com/sms.do';
        }
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $params);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $this->token"
        ));
        $content = curl_exec($c);
        $http_status = curl_getinfo($c, CURLINFO_HTTP_CODE);
        if ($http_status != 200 && $backup == false) {
            $backup = true;
            $this->sms_send_oauth($params, $backup);
        }
        curl_close($c);
        return $content;
    }

}
