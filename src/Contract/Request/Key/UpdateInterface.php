<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request\Key;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\RequestInterface;

interface UpdateInterface extends RequestInterface
{
	public function getKeyId(): int;

	public function getKeyName(): string;

	public function isRemoteUnlock(): ?bool;

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
