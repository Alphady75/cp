<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailerService {

   private $siteEmail = 'noreplay@contact.com';

	public function __construct(private MailerInterface $mailer){

	}

	public function sendMail($subjet, $message){

		$email = (new TemplatedEmail())
			->from(new Address($this->siteEmail, 'C+'))
			->to($this->siteEmail)
			->subject($subjet)
			->htmlTemplate('mails/_notification.html.twig')
			->context([
				'subjet' => $subjet,
				'message' => $message,
			])
		;

		return $this->mailer->send($email);
	}
}