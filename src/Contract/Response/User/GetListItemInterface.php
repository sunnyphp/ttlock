<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Response\User;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Response\ResponseInterface;

interface GetListItemInterface extends ResponseInterface
{
	/**
	 * The prefixed username return by Cloud API
	 * @return string
	 */
	public function getUsername(): string;

	/**
	 * Register time (timestamp in milliseconds)
	 * @return int
	 */
	public function getRegisterTimeStamp(): int;

	/**
	 * Register time
	 * @return DateTimeImmutable
	 */
	public function getRegisterDateTime(): DateTimeImmutable;
}
