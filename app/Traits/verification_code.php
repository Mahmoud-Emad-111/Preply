<?php

namespace App\Traits;

use Twilio\Rest\Client;

trait verification_code
{
    public function SentCode($code,$phone)
    {
        $sid = getenv("TWILIO_SID");
        $token = getenv("TWILIO_TOKEN");
        $twilio = new Client($sid, $token);

        $message = $twilio->messages
                ->create('+'.$phone, // to
                        [
                            "body" => $code,
                            "from" =>'+15137131530'
                        ]
        );

    }


}
