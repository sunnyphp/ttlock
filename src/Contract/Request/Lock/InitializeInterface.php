<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request\Lock;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\RequestInterface;

interface InitializeInterface extends RequestInterface
{
	public function getLockData(): string;

	public function getLockAlias(): ?string;

	public function getGroupId(): ?int;

	public function getNbInitSuccess(): ?bool;

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
