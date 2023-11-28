<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\Key;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Key\GetListInterface;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Exception\KeyException;
use SunnyPHP\TTLock\Helper\DateTime;
use Webmozart\Assert\Assert;

final class GetList implements GetListInterface
{
	private int $pageNo;
	private int $pageSize;
	private ?string $lockAlias;
	private ?int $groupId;
	private DateTimeImmutable $currentDateTime;

	/**
	 * @param int $pageNo Page no, start from 1
	 * @param int $pageSize Items per page, max 1000
	 * @param string|null $lockAlias Lock alias
	 * @param int|null $groupId Group ID
	 * @param DateTimeImmutable|null $currentDateTime Current date
	 */
	public function __construct(
		int $pageNo = 1,
		int $pageSize = 100,
		?string $lockAlias = null,
		?int $groupId = null,
		?DateTimeImmutable $currentDateTime = null
	) {
		Assert::nullOrStringNotEmpty($lockAlias, 'Lock alias should be filled or NULL');
		Assert::greaterThanEq($pageNo, 1, 'Page no should be greater or equals 1');
		Assert::range($pageSize, 1, 1000, 'Page size range should be [1, 1000]');

		$this->pageNo = $pageNo;
		$this->pageSize = $pageSize;
		$this->lockAlias = $lockAlias;
		$this->groupId = $groupId;
		$this->currentDateTime = $currentDateTime ?: new DateTimeImmutable();
	}

	public function getPageNo(): int
	{
		return $this->pageNo;
	}

	public function getPageSize(): int
	{
		return $this->pageSize;
	}

	public function getLockAlias(): ?string
	{
		return $this->lockAlias;
	}

	public function getGroupId(): ?int
	{
		return $this->groupId;
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
		return '/v3/key/list';
	}

	public function getEndpointMethod(): string
	{
		return Method::POST;
	}

	public function getRequestParams(): array
	{
		$params = [
			'pageNo' => $this->getPageNo(),
			'pageSize' => $this->getPageSize(),
			'date' => $this->getCurrentTimeStamp(),
		];

		if (($value = $this->getLockAlias()) !== null) {
			$params['lockAlias'] = $value;
		}

		if (($value = $this->getGroupId()) !== null) {
			$params['groupId'] = $value;
		}

		return $params;
	}
}
