<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request\User;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\RequestInterface;

interface GetListInterface extends RequestInterface
{
	/**
	 * Filter query by register time, unix time stamp in millisecond
	 * @see getStartDateTime
	 * @return int|null
	 */
	public function getStartTimeStamp(): ?int;

	/**
	 * Filter query by register time, start time
	 * @see getStartTimeStamp
	 * @return DateTimeImmutable|null
	 */
	public function getStartDateTime(): ?DateTimeImmutable;

	/**
	 * Filter query by register time, unix time stamp in millisecond
	 * @see getEndDateTime
	 * @return int|null
	 */
	public function getEndTimeStamp(): ?int;

	/**
	 * Filter query by register time, end time
	 * @see getEndTimeStamp
	 * @return DateTimeImmutable|null
	 */
	public function getEndDateTime(): ?DateTimeImmutable;

	/**
	 * Page no, start from 1
	 * @return int
	 */
	public function getPageNo(): int;

	/**
	 * Items per page, max 100
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
