<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request\Lock;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\RequestInterface;

interface GetListInterface extends RequestInterface
{
	public function getLockAlias(): ?string;

	public function getGroupId(): ?int;

	/**
	 * Page no, start from 1
	 * @return int
	 */
	public function getPageNo(): int;

	/**
	 * Items per page, default 20, max 1000
	 * @return int
	 */
	public function getPageSize(): int;

	/**
	 * Current unix time stamp in millisecond
	 * @see getCurrentDateTime
	 * @return int
	 */
	public function getCurrentTimeStamp(): int;

	/**
	 * Current date & time
	 * @see getCurrentTimeStamp
	 * @return DateTimeImmutable
	 */
	public function getCurrentDateTime(): DateTimeImmutable;
}
