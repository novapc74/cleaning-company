<?php

namespace App\MessageHandler;

use App\Service\MailerService;
use App\Message\EmailNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class EmailNotificationHandler
{
	public function __construct(private readonly MailerService $mailerService)
	{
	}

	public function __invoke(EmailNotification $message): void
	{
		$this->mailerService->resolveMailer($message->getFeedback());
	}
}