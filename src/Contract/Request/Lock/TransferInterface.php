<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request\Lock;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\RequestInterface;

interface TransferInterface extends RequestInterface
{
	/**
	 * The receiver's username
	 * @return string
	 */
	public function getReceiverUsername(): string;

	/**
	 * Transferred lock ID's
	 * @return int[]
	 */
	public function getLockIds(): array;

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
