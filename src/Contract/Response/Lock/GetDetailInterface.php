<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Response\Lock;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Response\ResponseInterface;

interface GetDetailInterface extends ResponseInterface
{
	/**
	 * Lock ID
	 * @return int
	 */
	public function getLockId(): int;

	/**
	 * Lock name
	 * @return string
	 */
	public function getLockName(): string;

	/**
	 * Lock alias
	 * @return string
	 */
	public function getLockAlias(): string;

	/**
	 * Lock MAC
	 * @return string
	 */
	public function getLockMac(): string;

	/**
	 * Super passcode, which only belongs to the admin ekey, can be entered on the keypad to unlock
	 * @return string
	 */
	public function getNoKeyPassword(): string;

	/**
	 * Lock battery level
	 * @return int
	 */
	public function getElectricQuantity(): int;

	/**
	 * Characteristic value. It's used to indicate what kinds of feature do a lock support.
	 * @return string
	 */
	public function getFeatureValue(): string;

	/**
	 * The offset between your time zone and UTC, in millisecond
	 * @return int
	 */
	public function getTimeZoneRawOffset(): int;

	/**
	 * Product model (for firmware update)
	 * @return string
	 */
	public function getModelNumber(): string;

	/**
	 * Hardware version (for firmware update)
	 * @return string
	 */
	public function getHardwareRevision(): string;

	/**
	 * Firmware version (for firmware update)
	 * @return string
	 */
	public function getFirmwareRevision(): string;

	/**
	 * Auto lock time (in seconds), -1 for disable auto lock
	 * @return int
	 */
	public function getAutoLockTime(): int;

	/**
	 * Lock sound: 0 - unknown, 1 - on, 2 - off
	 * @return int
	 */
	public function getLockSound(): int;

	/**
	 * Privacy lock: 0 - unknown, 1 - on, 2 - off
	 * @return int
	 */
	public function getPrivacyLock(): int;

	/**
	 * Tamper alert: 0 - unknown, 1 - on, 2 - off
	 * @return int
	 */
	public function getTamperAlert(): int;

	/**
	 * Reset button: 0 - unknown, 1 - on, 2 - off
	 * @return int
	 */
	public function getResetButton(): int;

	/**
	 * Open direction: 0 - unknown, 1 - left open, 2 - right open
	 * @return int
	 */
	public function getOpenDirection(): int;

	/**
	 * Passage mode: 1 - enable, 2 - disable
	 * @return int
	 */
	public function getPassageMode(): int;

	/**
	 * Passage mode auto unlock: 1 - on, 2 - off, set to 1 then the lock will auto unlock at the time the passage mode start
	 * @return int
	 */
	public function getPassageModeAutoUnlock(): int;

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
