<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\User;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Contract\Request\User\DeleteInterface;
use Webmozart\Assert\Assert;

final class Delete implements DeleteInterface
{
	private string $username;
	private DateTimeImmutable $currentTime;

	/**
	 * @param string $username Username for delete in API
	 * @param DateTimeImmutable|null $currentDate Current date
	 */
	public function __construct(
		string $username,
		?DateTimeImmutable $currentDate = null
	) {
		Assert::stringNotEmpty($username, 'Username parameter should be non-empty string');
		Assert::regex($username, '~^\w+$~', 'Username should contain only english characters or/and numbers');

		$this->username = $username;
		$this->currentTime = $currentDate ?: new DateTimeImmutable();
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function getCurrentTime(): DateTimeImmutable
	{
		return $this->currentTime;
	}

	public function getRequiredConfiguration(): int
	{
		return RequiredConfiguration::CLIENT_ID | RequiredConfiguration::CLIENT_SECRET;
	}

	public function getEndpointUrl(): string
	{
		return '/v3/user/delete';
	}

	public function getEndpointMethod(): string
	{
		return Method::POST;
	}

	public function toArray(): array
	{
		return [
			'username' => $this->getUsername(),
			'date' => $this->getCurrentTime()->getTimestamp() * 1000,
		];
	}
}
