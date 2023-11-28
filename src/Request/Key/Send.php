<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\Key;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Key\SendInterface;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Exception\KeyException;
use SunnyPHP\TTLock\Helper\DateTime;
use Webmozart\Assert\Assert;

final class Send implements SendInterface
{
	private int $lockId;
	private string $receiverUsername;
	private string $keyName;
	private ?bool $managementRight;
	private ?bool $remoteUnlock;
	private ?bool $autoCreateUser;
	private ?string $remarks;
	private DateTimeImmutable $startDateTime;
	private DateTimeImmutable $endDateTime;
	private DateTimeImmutable $currentDateTime;

	/**
	 * @param int $lockId Lock ID
	 * @param string $receiverUsername New key owner username
	 * @param string $keyName Key name
	 * @param DateTimeImmutable $startDateTime Time, then key become valid
	 * @param DateTimeImmutable $endDateTime Time, then key is expired
	 * @param bool|null $managementRight Management rights to change settings, key sharing, etc
	 * @param bool|null $remoteUnlock Remote unlock
	 * @param bool|null $autoCreateUser Auto create user if not exists
	 * @param string|null $remarks Key comments
	 * @param DateTimeImmutable|null $currentDateTime
	 */
	public function __construct(
		int $lockId,
		string $receiverUsername,
		string $keyName,
		DateTimeImmutable $startDateTime,
		DateTimeImmutable $endDateTime,
		?bool $managementRight = null,
		?bool $remoteUnlock = null,
		?bool $autoCreateUser = null,
		?string $remarks = null,
		?DateTimeImmutable $currentDateTime = null
	) {
		Assert::notEmpty($receiverUsername, 'Receiver username parameter should be filled');
		Assert::notEmpty($keyName, 'Key name parameter should be filled');
		Assert::true($endDateTime > $startDateTime, 'EndDateTime parameter should be greater than StartDateTime parameter');
		Assert::nullOrNotEmpty($remarks, 'Remarks parameter should be filled or NULL');

		$this->lockId = $lockId;
		$this->receiverUsername = $receiverUsername;
		$this->keyName = $keyName;
		$this->startDateTime = $startDateTime;
		$this->endDateTime = $endDateTime;
		$this->managementRight = $managementRight;
		$this->remoteUnlock = $remoteUnlock;
		$this->autoCreateUser = $autoCreateUser;
		$this->remarks = $remarks;
		$this->currentDateTime = $currentDateTime ?: new DateTimeImmutable();
	}

	public function getLockId(): int
	{
		return $this->lockId;
	}

	public function getKeyName(): string
	{
		return $this->keyName;
	}

	public function getReceiverUsername(): string
	{
		return $this->receiverUsername;
	}

	public function isManagementRight(): ?bool
	{
		return $this->managementRight;
	}

	public function isRemoteUnlock(): ?bool
	{
		return $this->remoteUnlock;
	}

	public function isAutoCreateUser(): bool
	{
		return $this->autoCreateUser;
	}

	public function getRemarks(): ?string
	{
		return $this->remarks;
	}

	public function getStartTimeStamp(): int
	{
		return DateTime::getUv($this->startDateTime);
	}

	public function getStartDateTime(): DateTimeImmutable
	{
		return $this->startDateTime;
	}

	public function getEndTimeStamp(): int
	{
		return DateTime::getUv($this->endDateTime);
	}

	public function getEndDateTime(): DateTimeImmutable
	{
		return $this->endDateTime;
	}

	public function getCurrentTimeStamp(): int
	{
		return DateTime::getUv($this->currentDateTime);
	}

	public function getCurrentDateTime(): DateTimeImmutable
	{
		return $this->currentDateTime;
	}

	public function getExceptionClass(): string
	{
		return KeyException::class;
	}

	public function getRequiredConfiguration(): int
	{
		return RequiredConfiguration::CLIENT_ID | RequiredConfiguration::ACCESS_TOKEN;
	}

	public function getEndpointUrl(): string
	{
		return '/v3/key/send';
	}

	public function getEndpointMethod(): string
	{
		return Method::POST;
	}

	public function getRequestParams(): array
	{
		$params = [
			'lockId' => $this->getLockId(),
			'receiverUsername' => $this->getReceiverUsername(),
			'keyName' => $this->getKeyName(),
			'startDate' => $this->getStartTimeStamp(),
			'endDate' => $this->getEndTimeStamp(),
			'date' => $this->getCurrentTimeStamp(),
		];

		if (($value = $this->isManagementRight()) !== null) {
			$params['keyRight'] = (int) $value;
		}

		if (($value = $this->isRemoteUnlock()) !== null) {
			$params['remoteEnable'] = $value ? 1 : 2;
		}

		if (($value = $this->isAutoCreateUser()) !== null) {
			$params['createUser'] = $value ? 1 : 2;
		}

		if (($value = $this->getRemarks()) !== null) {
			$params['remarks'] = $value;
		}

		return $params;
	}
}
