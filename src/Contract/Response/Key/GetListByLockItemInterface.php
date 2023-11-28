<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Response\Key;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Response\ResponseInterface;

interface GetListByLockItemInterface extends ResponseInterface
{
	/**
	 * Lock ID, generated after initialization
	 * @return int
	 */
	public function getLockId(): int;

	/**
	 * Key owner user ID
	 * @return int
	 */
	public function getUserId(): int;

	/**
	 * Key owner username
	 * @return string
	 */
	public function getUsername(): string;

	/**
	 * Sender's username
	 * @return string
	 */
	public function getSenderUsername(): string;

	/**
	 * Key ID
	 * @return int
	 */
	public function getKeyId(): int;

	public function getKeyName(): string;

	/**
	 * Key status: 110401 - Normal, 110402 - Pending, 110405 - Frozen, 110408 - Deleted, 110410 - Reseted
	 * @return string
	 */
	public function getKeyStatus(): string;

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

	/**
	 * Send key unix time stamp in millisecond
	 * @see getCurrentDateTime
	 * @return int
	 */
	public function getSendTimeStamp(): int;

	/**
	 * Send key date & time
	 * @see getCurrentTimeStamp
	 * @return DateTimeImmutable
	 */
	public function getSendDateTime(): DateTimeImmutable;
}
