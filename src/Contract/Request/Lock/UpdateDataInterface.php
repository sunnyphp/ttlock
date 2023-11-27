<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request\Lock;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\RequestInterface;

interface UpdateDataInterface extends RequestInterface
{
	public function getLockId(): int;

	/**
	 * Lock data from App SDK
	 * @return string
	 */
	public function getLockData(): string;

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
