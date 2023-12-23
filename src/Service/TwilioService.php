<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{
   private $twilloAccountSid;

   private $twilioAuthToken;

   public function __construct()
   {
      $this->twilloAccountSid = $_ENV['TWILIO_ACCOUNT_SID'];

      $this->twilioAuthToken = $_ENV['TWILIO_AUTH_TOKEN'];
   }

   public function sendSms($to, $contenu)
   {
      $from = "+15077086858";
      $client = new Client($this->twilloAccountSid, $this->twilioAuthToken);
      $client->messages->create(
         // Where to send a text message (your cell phone?)
         $to,
         array(
            'from' => $from,
            'body' => $contenu
         )
      );
   }
}
