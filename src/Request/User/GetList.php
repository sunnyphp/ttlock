<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\User;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Contract\Request\User\GetListInterface;
use Webmozart\Assert\Assert;

final class GetList implements GetListInterface
{
	private int $pageNo;
	private int $pageSize;
	private DateTimeImmutable $currentDateTime;
	private ?DateTimeImmutable $startDateTime;
	private ?DateTimeImmutable $endDateTime;

	/**
	 * @param int $pageNo Page no, start from 1
	 * @param int $pageSize Items per page, max 100
	 * @param DateTimeImmutable|null $currentDateTime Current date
	 * @param DateTimeImmutable|null $startDateTime Filter, start date
	 * @param DateTimeImmutable|null $endDateTime Filter, end date
	 */
	public function __construct(
		int $pageNo = 1,
		int $pageSize = 100,
		?DateTimeImmutable $currentDateTime = null,
		?DateTimeImmutable $startDateTime = null,
		?DateTimeImmutable $endDateTime = null
	) {
		Assert::greaterThanEq($pageNo, 1, 'Page no should be greater or equals 1');
		Assert::range($pageSize, 1, 100, 'Page size range should be [1, 100]');

		$this->pageNo = $pageNo;
		$this->pageSize = $pageSize;
		$this->currentDateTime = $currentDateTime ?: new DateTimeImmutable();
		$this->startDateTime = $startDateTime;
		$this->endDateTime = $endDateTime;
	}

	public function getStartTimeStamp(): ?int
	{
		if (($dateTime = $this->getStartDateTime()) === null) {
			return null;
		}

		return (int) $dateTime->format('Uv');
	}

	public function getStartDateTime(): ?DateTimeImmutable
	{
		return $this->startDateTime;
	}

	public function getEndTimeStamp(): ?int
	{
		if (($dateTime = $this->getEndDateTime()) === null) {
			return null;
		}

		return (int) $dateTime->format('Uv');
	}

	public function getEndDateTime(): ?DateTimeImmutable
	{
		return $this->endDateTime;
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
		return (int) $this->getCurrentDateTime()->format('Uv');
	}

	public function getCurrentDateTime(): DateTimeImmutable
	{
		return $this->currentDateTime;
	}

	public function getRequiredConfiguration(): int
	{
		return RequiredConfiguration::CLIENT_ID | RequiredConfiguration::CLIENT_SECRET;
	}

	public function getEndpointUrl(): string
	{
		return '/v3/user/list';
	}

	public function getEndpointMethod(): string
	{
		return Method::GET;
	}

	public function getRequestParams(): array
	{
		$params['pageNo'] = $this->getPageNo();
		$params['pageSize'] = $this->getPageSize();
		$params['date'] = $this->getCurrentTimeStamp();

		if ($startTimeStamp = $this->getStartTimeStamp()) {
			$params['startDate'] = $startTimeStamp;
		}

		if ($endTimeStamp = $this->getEndTimeStamp()) {
			$params['endDate'] = $endTimeStamp;
		}

		return $params;
	}
}
