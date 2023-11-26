<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\User;

use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Contract\Request\User\GetListInterface;
use Webmozart\Assert\Assert;

final class GetList implements GetListInterface
{
	private int $pageNo;
	private int $pageSize;
	private int $date;
	private ?int $startDate;
	private ?int $endDate;

	/**
	 * @param int $pageNo Page no, start from 1
	 * @param int $pageSize Items per page, max 100
	 * @param int|null $currentDate Current date
	 * @param int|null $startDate Filter, start date
	 * @param int|null $endDate Filter, end date
	 */
	public function __construct(
		int $pageNo = 1,
		int $pageSize = 100,
		?int $currentDate = null,
		?int $startDate = null,
		?int $endDate = null
	) {
		Assert::greaterThanEq($pageNo, 1, 'Page no should be greater or equals 1');
		Assert::range($pageSize, 1, 100, 'Page size range should be [1, 100]');

		$this->pageNo = $pageNo;
		$this->pageSize = $pageSize;
		$this->date = $currentDate ?: (time() * 1000);
		$this->startDate = $startDate;
		$this->endDate = $endDate;
	}

	public function getStartDate(): ?int
	{
		return $this->startDate;
	}

	public function getEndDate(): ?int
	{
		return $this->endDate;
	}

	public function getPageNo(): int
	{
		return $this->pageNo;
	}

	public function getPageSize(): int
	{
		return $this->pageSize;
	}

	public function getDate(): int
	{
		return $this->date;
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
		$ret['pageNo'] = $this->getPageNo();
		$ret['pageSize'] = $this->getPageSize();
		$ret['date'] = $this->getDate();

		if ($startDate = $this->getStartDate()) {
			$ret['startDate'] = $startDate;
		}

		if ($endDate = $this->getEndDate()) {
			$ret['endDate'] = $endDate;
		}

		return $ret;
	}
}
