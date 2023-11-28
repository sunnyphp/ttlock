<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\Lock;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Lock\RenameInterface;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Exception\LockException;
use SunnyPHP\TTLock\Helper\DateTime;
use Webmozart\Assert\Assert;

final class Rename implements RenameInterface
{
	private int $lockId;
	private string $lockAlias;
	private DateTimeImmutable $currentDateTime;

	/**
	 * @param int $lockId Lock ID
	 * @param string $lockAlias New lock alias name
	 * @param DateTimeImmutable|null $currentDateTime Current date
	 */
	public function __construct(
		int $lockId,
		string $lockAlias,
		?DateTimeImmutable $currentDateTime = null
	) {
		Assert::notEmpty($lockAlias, 'Lock alias parameter should be filled');

		$this->lockId = $lockId;
		$this->lockAlias = $lockAlias;
		$this->currentDateTime = $currentDateTime ?: new DateTimeImmutable();
	}

	public function getLockId(): int
	{
		return $this->lockId;
	}

	public function getLockAlias(): string
	{
		return $this->lockAlias;
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
		return '/v3/lock/rename';
	}

	public function getEndpointMethod(): string
	{
		return Method::POST;
	}

	public function getRequestParams(): array
	{
		return [
			'lockId' => $this->getLockId(),
			'lockAlias' => $this->getLockAlias(),
			'date' => $this->getCurrentTimeStamp(),
		];
	}
}
