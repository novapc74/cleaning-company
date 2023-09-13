<?php

namespace App\Message;

use App\Entity\Feedback;
use App\Service\MailerService;

class EmailNotification
{
	public function __construct(private readonly MailerService $mailerService, private readonly Feedback $feedback)
	{
	}

	public function sendEmail(): void
	{
		$this->mailerService->resolveMailer($this->feedback);
	}

}