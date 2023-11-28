<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request\Key;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\RequestInterface;

interface AuthorizeInterface extends RequestInterface
{
	public function getLockId(): int;

	public function getKeyId(): int;

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
