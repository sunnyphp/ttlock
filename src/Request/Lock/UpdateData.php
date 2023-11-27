<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\Lock;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Lock\UpdateDataInterface;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Helper\DateTime;
use Webmozart\Assert\Assert;

final class UpdateData implements UpdateDataInterface
{
	private int $lockId;
	private string $lockData;
	private DateTimeImmutable $currentDateTime;

	/**
	 * @param int $lockId Lock ID
	 * @param string $lockData Lock data from App SDK
	 * @param DateTimeImmutable|null $currentDateTime Current date
	 */
	public function __construct(
		int $lockId,
		string $lockData,
		?DateTimeImmutable $currentDateTime = null
	) {
		Assert::notEmpty($lockData, 'Lock data parameter should be filled');

		$this->lockId = $lockId;
		$this->lockData = $lockData;
		$this->currentDateTime = $currentDateTime ?: new DateTimeImmutable();
	}

	public function getLockId(): int
	{
		return $this->lockId;
	}

	public function getLockData(): string
	{
		return $this->lockData;
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
		return '/v3/lock/updateLockData';
	}

	public function getEndpointMethod(): string
	{
		return Method::POST;
	}

	public function getRequestParams(): array
	{
		return [
			'lockId' => $this->getLockId(),
			'lockData' => $this->getLockData(),
			'date' => $this->getCurrentTimeStamp(),
		];
	}
}
