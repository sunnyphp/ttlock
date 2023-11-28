<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\Lock;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Lock\UpdateElectricQuantityInterface;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Exception\LockException;
use SunnyPHP\TTLock\Helper\DateTime;

final class UpdateElectricQuantity implements UpdateElectricQuantityInterface
{
	private int $lockId;
	private int $electricQuantity;
	private DateTimeImmutable $currentDateTime;

	/**
	 * @param int $lockId Lock ID
	 * @param int $electricQuantity Lock battery level
	 * @param DateTimeImmutable|null $currentDateTime Current date
	 */
	public function __construct(
		int $lockId,
		int $electricQuantity,
		?DateTimeImmutable $currentDateTime = null
	) {
		$this->lockId = $lockId;
		$this->electricQuantity = $electricQuantity;
		$this->currentDateTime = $currentDateTime ?: new DateTimeImmutable();
	}

	public function getLockId(): int
	{
		return $this->lockId;
	}

	public function getElectricQuantity(): int
	{
		return $this->electricQuantity;
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
		return LockException::class;
	}

	public function getRequiredConfiguration(): int
	{
		return RequiredConfiguration::CLIENT_ID | RequiredConfiguration::ACCESS_TOKEN;
	}

	public function getEndpointUrl(): string
	{
		return '/v3/lock/updateElectricQuantity';
	}

	public function getEndpointMethod(): string
	{
		return Method::POST;
	}

	public function getRequestParams(): array
	{
		return [
			'lockId' => $this->getLockId(),
			'electricQuantity' => $this->getElectricQuantity(),
			'date' => $this->getCurrentTimeStamp(),
		];
	}
}
