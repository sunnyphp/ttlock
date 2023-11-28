<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\Key;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Key\GetListByLockInterface;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Exception\KeyException;
use SunnyPHP\TTLock\Helper\DateTime;
use Webmozart\Assert\Assert;

final class GetListByLock implements GetListByLockInterface
{
	private ?int $lockId;
	private int $pageNo;
	private int $pageSize;
	private DateTimeImmutable $currentDateTime;

	/**
	 * @param int $lockId Group ID
	 * @param int $pageNo Page no, start from 1
	 * @param int $pageSize Items per page, max 100
	 * @param DateTimeImmutable|null $currentDateTime Current date
	 */
	public function __construct(
		int $lockId,
		int $pageNo = 1,
		int $pageSize = 100,
		?DateTimeImmutable $currentDateTime = null
	) {
		Assert::greaterThanEq($pageNo, 1, 'Page no should be greater or equals 1');
		Assert::range($pageSize, 1, 100, 'Page size range should be [1, 100]');

		$this->lockId = $lockId;
		$this->pageNo = $pageNo;
		$this->pageSize = $pageSize;
		$this->currentDateTime = $currentDateTime ?: new DateTimeImmutable();
	}

	public function getLockId(): int
	{
		return $this->lockId;
	}

	public function getPageNo(): int
	{
		return $this->pageNo;
	}

	public function getPageSize(): int
	{
		return $this->pageSize;
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
		return '/v3/lock/listKey';
	}

	public function getEndpointMethod(): string
	{
		return Method::GET;
	}

	public function getRequestParams(): array
	{
		return [
			'lockId' => $this->getLockId(),
			'pageNo' => $this->getPageNo(),
			'pageSize' => $this->getPageSize(),
			'date' => $this->getCurrentTimeStamp(),
		];
	}
}
