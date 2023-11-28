<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\Lock;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Lock\TransferInterface;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Exception\LockException;
use SunnyPHP\TTLock\Helper\DateTime;
use Webmozart\Assert\Assert;

final class Transfer implements TransferInterface
{
	private string $receiverUsername;
	private array $lockIds;
	private DateTimeImmutable $currentDateTime;

	/**
	 * @param string $receiverUsername Receiver's username
	 * @param array $lockIds Lock ID's
	 * @param DateTimeImmutable|null $currentDateTime Current date
	 */
	public function __construct(
		string $receiverUsername,
		array $lockIds,
		?DateTimeImmutable $currentDateTime = null
	) {
		Assert::notEmpty($receiverUsername, 'Receiver username parameter should be filled');
		Assert::notEmpty($lockIds, 'Lock IDs should be filled');
		Assert::allPositiveInteger($lockIds, 'Lock IDs should be positive integers');

		$this->receiverUsername = $receiverUsername;
		$this->lockIds = $lockIds;
		$this->currentDateTime = $currentDateTime ?: new DateTimeImmutable();
	}

	public function getReceiverUsername(): string
	{
		return $this->receiverUsername;
	}

	public function getLockIds(): array
	{
		return $this->lockIds;
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
		return '/v3/lock/transfer';
	}

	public function getEndpointMethod(): string
	{
		return Method::POST;
	}

	public function getRequestParams(): array
	{
		return [
			'receiverUsername' => $this->getReceiverUsername(),
			'lockIdList' => implode(',', $this->getLockIds()),
			'date' => $this->getCurrentTimeStamp(),
		];
	}
}
