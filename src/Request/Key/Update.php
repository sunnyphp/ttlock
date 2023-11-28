<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\Key;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Key\UpdateInterface;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Exception\KeyException;
use SunnyPHP\TTLock\Helper\DateTime;
use Webmozart\Assert\Assert;

final class Update implements UpdateInterface
{
	private int $keyId;
	private ?string $keyName;
	private ?bool $remoteUnlock;
	private DateTimeImmutable $currentDateTime;

	/**
	 * @param int $keyId Key ID
	 * @param DateTimeImmutable|null $currentDateTime Current date
	 */
	public function __construct(
		int $keyId,
		?string $keyName = null,
		?bool $remoteUnlock = false,
		?DateTimeImmutable $currentDateTime = null
	) {
		Assert::nullOrNotEmpty($keyName, 'Key name parameter should be filled or NULL');

		$this->keyId = $keyId;
		$this->keyName = $keyName;
		$this->remoteUnlock = $remoteUnlock;
		$this->currentDateTime = $currentDateTime ?: new DateTimeImmutable();
	}

	public function getKeyId(): int
	{
		return $this->keyId;
	}

	public function getKeyName(): string
	{
		return $this->keyName;
	}

	public function isRemoteUnlock(): ?bool
	{
		return $this->remoteUnlock;
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
		return '/v3/key/update';
	}

	public function getEndpointMethod(): string
	{
		return Method::POST;
	}

	public function getRequestParams(): array
	{
		$params = [
			'keyId' => $this->getKeyId(),
			'date' => $this->getCurrentTimeStamp(),
		];

		if (($value = $this->getKeyName()) !== null) {
			$params['keyName'] = $value;
		}

		if (($value = $this->isRemoteUnlock()) !== null) {
			$params['remoteEnable'] = $value ? 1 : 2;
		}

		return $params;
	}
}
