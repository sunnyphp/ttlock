<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\Lock;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Lock\DeleteInterface;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Helper\DateTime;

final class Delete implements DeleteInterface
{
	private int $lockId;
	private DateTimeImmutable $currentDateTime;

	/**
	 * @param int $lockId Lock ID
	 * @param DateTimeImmutable|null $currentDateTime Current date
	 */
	public function __construct(
		int $lockId,
		?DateTimeImmutable $currentDateTime = null
	) {
		$this->lockId = $lockId;
		$this->currentDateTime = $currentDateTime ?: new DateTimeImmutable();
	}

	public function getLockId(): int
	{
		return $this->lockId;
	}

	public function getCurrentTimeStamp(): int
	{
		return DateTime::getUv($this->currentDateTime);
	}

	public function getCurrentDateTime(): DateTimeImmutable
	{
		return $this->currentDateTime;
	}

	public function getRequiredConfiguration(): int
	{
		return RequiredConfiguration::CLIENT_ID | RequiredConfiguration::ACCESS_TOKEN;
	}

	public function getEndpointUrl(): string
	{
		return '/v3/lock/delete';
	}

	public function getEndpointMethod(): string
	{
		return Method::POST;
	}

	public function getRequestParams(): array
	{
		return [
			'lockId' => $this->getLockId(),
			'date' => $this->getCurrentTimeStamp(),
		];
	}
}
