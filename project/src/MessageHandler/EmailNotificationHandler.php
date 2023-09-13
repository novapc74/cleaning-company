<?php

namespace App\MessageHandler;

use App\Message\EmailNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class EmailNotificationHandler
{
	public function __invoke(EmailNotification $message): void
	{
		$message->sendEmail();
	}
}