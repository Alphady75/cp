<?php

namespace App\Service;

use MessageBird\Client;
use MessageBird\Objects\Message;

class MessageBirdService
{
   private $messageBirdKey;

   public function __construct()
   {
      $this->messageBirdKey = $_ENV['MESSAGE_BIRD_ACCESS_KEY'];
   }

   public function sendSms($to, $contenu)
   {
      $messagebird = new \MessageBird\Client($this->messageBirdKey);

      $message = new \MessageBird\Objects\Message;
      $message->originator = $to;
      $message->recipients = ['+31612345678'];
      $message->body = $contenu;
      $response = $messagebird->messages->create($message);

      dd($response);

      return $response;
   }
}
