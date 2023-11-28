<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\Key;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Key\UnauthorizeInterface;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Exception\KeyException;
use SunnyPHP\TTLock\Helper\DateTime;

final class Unauthorize implements UnauthorizeInterface
{
	private int $lockId;
	private int $keyId;
	private DateTimeImmutable $currentDateTime;

	/**
	 * @param int $lockId Lock ID
	 * @param int $keyId Key ID
	 * @param DateTimeImmutable|null $currentDateTime Current date
	 */
	public function __construct(
		int $lockId,
		int $keyId,
		?DateTimeImmutable $currentDateTime = null
	) {
		$this->lockId = $lockId;
		$this->keyId = $keyId;
		$this->currentDateTime = $currentDateTime ?: new DateTimeImmutable();
	}

	public function getLockId(): int
	{
		return $this->lockId;
	}

	public function getKeyId(): int
	{
		return $this->keyId;
	}

	public function getCurrentTimeStamp(): int
	{
		return DateTime::getUv($this->currentDateTime);
	}

	public function getCurrentDateTime(): DateTimeImmutable
	{
		return $this->currentDateTime;
	}

	public function getExceptionClass(): string
	{
		return KeyException::class;
	}

	public function getRequiredConfiguration(): int
	{
		return RequiredConfiguration::CLIENT_ID | RequiredConfiguration::ACCESS_TOKEN;
	}

	public function getEndpointUrl(): string
	{
		return '/v3/key/unauthorize';
	}

	public function getEndpointMethod(): string
	{
		return Method::POST;
	}

	public function getRequestParams(): array
	{
		return [
			'lockId' => $this->getLockId(),
			'keyId' => $this->getKeyId(),
			'date' => $this->getCurrentTimeStamp(),
		];
	}
}
