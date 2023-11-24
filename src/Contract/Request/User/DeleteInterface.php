<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request\User;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\RequestInterface;

interface DeleteInterface extends RequestInterface
{
	/**
	 * Username for delete (only numbers and english letters)
	 * @return string
	 */
	public function getUsername(): string;

	/**
	 * Current time
	 * @return DateTimeImmutable
	 */
	public function getCurrentTime(): DateTimeImmutable;
}
