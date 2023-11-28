<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\Key;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Key\FreezeInterface;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Exception\KeyException;
use SunnyPHP\TTLock\Helper\DateTime;

final class Freeze implements FreezeInterface
{
	private int $keyId;
	private DateTimeImmutable $currentDateTime;

	/**
	 * @param int $keyId Key ID
	 * @param DateTimeImmutable|null $currentDateTime Current date
	 */
	public function __construct(
		int $keyId,
		?DateTimeImmutable $currentDateTime = null
	) {
		$this->keyId = $keyId;
		$this->currentDateTime = $currentDateTime ?: new DateTimeImmutable();
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
		return '/v3/key/freeze';
	}

	public function getEndpointMethod(): string
	{
		return Method::POST;
	}

	public function getRequestParams(): array
	{
		return [
			'keyId' => $this->getKeyId(),
			'date' => $this->getCurrentTimeStamp(),
		];
	}
}
