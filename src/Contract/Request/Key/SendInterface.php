<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request\Key;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\RequestInterface;

interface SendInterface extends RequestInterface
{
	public function getLockId(): int;

	/**
	 * Key receiver username
	 * @return string
	 */
	public function getReceiverUsername(): string;

	/**
	 * Key name
	 * @return string
	 */
	public function getKeyName(): string;

	/**
	 * Returns True if key has management right of a lock to an ekey user, including rights of sending keys, creating passcodes, lock settings, etc.;
	 * null if not set
	 * @return bool|null
	 */
	public function isManagementRight(): ?bool;

	/**
	 * Returns True if remote enabled, null if not set
	 * @return bool|null
	 */
	public function isRemoteUnlock(): ?bool;

	/**
	 * Auto create TTLock account if receiverUsername is not a registered TTLock account.
	 * This parameter take effect only when receiverUsername is a mobile number or email, the created account's password is
	 * the last six characters of the username.
	 * @return bool
	 */
	public function isAutoCreateUser(): bool;

	/**
	 * Key comments, null if not set
	 * @return string|null
	 */
	public function getRemarks(): ?string;

	/**
	 * Key time when it becomes valid, unix time stamp in millisecond, null if not set
	 * @return int
	 */
	public function getStartTimeStamp(): int;

	/**
	 * Key time when it becomes valid, null if not set
	 * @return DateTimeImmutable
	 */
	public function getStartDateTime(): DateTimeImmutable;

	/**
	 * Key time when it is expired, unix time stamp in millisecond, null if not set
	 * @return int
	 */
	public function getEndTimeStamp(): int;

	/**
	 * Key time when it is expired, null if not set
	 * @return DateTimeImmutable
	 */
	public function getEndDateTime(): DateTimeImmutable;

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
