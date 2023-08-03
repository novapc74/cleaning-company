<?php

namespace App\Service;

use Exception;
use App\Entity\Feedback;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface as TransportException;

class MailerService
{
	public function __construct(private readonly MailerInterface $mailer,
	                            private readonly string          $mailSender,
	                            private readonly string          $mailRecipients)
	{
	}

	public function resolveMailer(Feedback $feedback): void
	{
		array_map(
			fn(TemplatedEmail $email) => $this->sendEmail($email),
			array_map(fn($type) => $this->makeEmail($feedback, $type), ['client', 'feedback'])
		);
	}

	/**
	 * @param $email
	 * @return Exception|TransportExceptionInterface|void
	 * @throws TransportException
	 */
	protected function sendEmail($email)
	{
		try {
			$this->mailer->send($email);
		} catch (TransportExceptionInterface $exception) {
			return $exception;
		}
	}

	private function makeEmail(Feedback $feedback, string $type): TemplatedEmail
	{
		$email = (new TemplatedEmail())
			->from($this->mailSender)
			->htmlTemplate('mailer/client_email.html.twig')
			->context([
				'feedback' => $feedback
			]);

		if ($type == 'client') {
			$email
				->addTo($feedback->getEmail())
				->subject('СПКК - Ваша заявка принята.')
				->htmlTemplate('mailer/client_email.html.twig');
		} else {
			$email
				->subject('СПКК - новая заявка с сайта.')
				->htmlTemplate('mailer/feedback_email.html.twig');

			array_map(
				fn(string $recipient) => $email->addTo($recipient),
				$this->getRecipientsEmail()
			);
		}

		return $email;
	}

	private function getRecipientsEmail(): array
	{
		return array_map(
			fn($recipient) => trim($recipient),
			explode(',', $this->mailRecipients)
		);
	}
}