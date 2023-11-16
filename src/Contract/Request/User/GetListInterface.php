<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request\User;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\RequestInterface;

interface GetListInterface extends RequestInterface
{
	/**
	 * Filter query by register time, start time (timestamp in millisecond)
	 * @return null|int
	 */
	public function getStartDate(): ?int;

	/**
	 * Filter query by register time, end time (timestamp in millisecond)
	 * @return null|int
	 */
	public function getEndDate(): ?int;

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
	 * Current time (timestamp in millisecond)
	 * @return int
	 */
	public function getDate(): int;
}
