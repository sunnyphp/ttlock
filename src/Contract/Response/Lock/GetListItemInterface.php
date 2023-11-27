<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Response\Lock;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Response\ResponseInterface;

interface GetListItemInterface extends ResponseInterface
{
	/**
	 * Lock ID, generated after initialization
	 * @return int
	 */
	public function getLockId(): int;

	public function getLockName(): string;

	public function getLockAlias(): ?string;

	public function getLockMac(): string;

	/**
	 * Battery level
	 * @return int
	 */
	public function getElectricQuantity(): int;

	/**
	 * String characteristic value. it is used to indicate what kinds of feature do a lock support.
	 * @return string
	 */
	public function getFeatureValue(): string;

	/**
	 * Is lock bound to gateway
	 * @return bool
	 */
	public function getHasGateway(): bool;

	/**
	 * Lock data, used to operate the lock
	 * @return string
	 */
	public function getLockData(): string;

	public function getGroupId(): ?int;

	public function getGroupName(): ?string;

	/**
	 * Lock initialize unix time stamp in millisecond
	 * @return int
	 */
	public function getInitializeTimeStamp(): int;

	/**
	 * Lock initialize time
	 * @return DateTimeImmutable
	 */
	public function getInitializeDateTime(): DateTimeImmutable;
}
