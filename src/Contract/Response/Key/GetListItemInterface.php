<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Response\Key;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Response\ResponseInterface;

interface GetListItemInterface extends ResponseInterface
{
	/**
	 * Key ID
	 * @return int
	 */
	public function getKeyId(): int;

	/**
	 * Lock data, used to operate lock
	 * @return string
	 */
	public function getLockData(): string;

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
	 * Key type: 110301 - admin ekey, 110302 - common user ekey
	 * @return string
	 */
	public function getUserType(): string;

	/**
	 * Returns True if key is admin type
	 * @return bool
	 */
	public function isAdminType(): bool;

	/**
	 * Key status: 110401 - Normal, 110402 - Pending, 110405 - Frozen, 110408 - Deleted, 110410 - Reseted
	 * @return string
	 */
	public function getKeyStatus(): string;

	/**
	 * Super passcode, which only belongs to the admin ekey, can be entered on the keypad to unlock
	 * @return string
	 */
	public function getNoKeyPassword(): string;

	public function getGroupId(): ?int;

	public function getGroupName(): ?string;

	/**
	 * Key comments
	 * @return string|null
	 */
	public function getRemarks(): ?string;

	/**
	 * Returns True if key has management right of a lock to an ekey user, including rights of sending keys, creating passcodes, lock settings, etc.
	 * @return bool
	 */
	public function isManagementRight(): bool;

	/**
	 * Returns True if remote enabled
	 * @return bool
	 */
	public function isRemoteEnabled(): bool;

	/**
	 * Returns True if passage mode
	 * @return bool
	 */
	public function isPassageMode(): bool;

	/**
	 * Key time when it becomes valid, unix time stamp in millisecond, null if not set
	 * @return int|null
	 */
	public function getStartTimeStamp(): ?int;

	/**
	 * Key time when it becomes valid, null if not set
	 * @return DateTimeImmutable|null
	 */
	public function getStartDateTime(): ?DateTimeImmutable;

	/**
	 * Key time when it is expired, unix time stamp in millisecond, null if not set
	 * @return int|null
	 */
	public function getEndTimeStamp(): ?int;

	/**
	 * Key time when it is expired, null if not set
	 * @return DateTimeImmutable|null
	 */
	public function getEndDateTime(): ?DateTimeImmutable;
}
