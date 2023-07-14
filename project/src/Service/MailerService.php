<?php

namespace App\Service;

use Exception;
use App\Entity\Feedback;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;

class MailerService
{
	public function __construct(private readonly MailerInterface $mailer,
	                            private readonly string          $mailSender,
	                            private readonly string          $mailRecipients)
	{
	}

	/**
	 * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
	 */
	public function resolveMailer(Feedback $feedback): void
	{
		$email = $this->makeEmail($feedback);

		$this->sendEmail($email);
	}

	/**
	 * @param $email
	 * @return Exception|TransportExceptionInterface|void
	 * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
	 */
	protected function sendEmail($email)
	{
		try {
			$this->mailer->send($email);
		} catch (TransportExceptionInterface $exception) {
			return $exception;
		}
	}

	private function makeEmail(Feedback $feedback): TemplatedEmail
	{
		$email = (new TemplatedEmail())
			->from($this->mailSender)
			->addTo($feedback->getEmail())
			->subject('Горстрой.')
			->htmlTemplate('mailer/email.html.twig')
			->context([
				'appeal' => $feedback
			]);

		/* add recipients to email */
		array_map(fn(string $recipient) => $email->addTo($recipient), $this->getRecipientsEmail());

		return $email;
	}

	private function getRecipientsEmail(): array
	{
		preg_match_all('~\s+\K\S+@\S+\.\S+\b~u', $this->mailRecipients, $matches, PREG_PATTERN_ORDER);

		return $matches[0];
	}
}