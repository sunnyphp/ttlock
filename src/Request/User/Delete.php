<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\User;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Contract\Request\User\DeleteInterface;
use SunnyPHP\TTLock\Exception\CommonException;
use SunnyPHP\TTLock\Helper\DateTime;
use Webmozart\Assert\Assert;

final class Delete implements DeleteInterface
{
	private string $username;
	private DateTimeImmutable $currentDateTime;

	/**
	 * @param string $username Username for delete in API
	 * @param DateTimeImmutable|null $currentDateTime Current date
	 */
	public function __construct(
		string $username,
		?DateTimeImmutable $currentDateTime = null
	) {
		Assert::stringNotEmpty($username, 'Username parameter should be non-empty string');
		Assert::regex($username, '~^\w+$~', 'Username should contain only english characters or/and numbers');

		$this->username = $username;
		$this->currentDateTime = $currentDateTime ?: new DateTimeImmutable();
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function getCurrentTimeStamp(): int
	{
		return DateTime::getUv($this->getCurrentDateTime());
	}

	public function getCurrentDateTime(): DateTimeImmutable
	{
		return $this->currentDateTime;
	}

	public function getExceptionClass(): string
	{
		return CommonException::class;
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

	public function getRequestParams(): array
	{
		return [
			'username' => $this->getUsername(),
			'date' => $this->getCurrentTimeStamp(),
		];
	}
}
