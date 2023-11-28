<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Response\Key;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Response\Key\GetListByLockItemInterface;
use SunnyPHP\TTLock\Helper\DateTime;
use SunnyPHP\TTLock\Response\AbstractResponse;

final class GetListByLockItem extends AbstractResponse implements GetListByLockItemInterface
{
	private ?DateTimeImmutable $startDateTime = null;
	private ?DateTimeImmutable $endDateTime = null;
	private ?DateTimeImmutable $sendDateTime = null;

	public function __construct(array $response)
	{
		$this->validateInteger($response, 'lockId', 'uid', 'keyId', 'electricQuantity');
		$this->validatePositiveInteger($response, 'startDate', 'endDate', 'date', 'keyRight', 'remoteEnable');
		$this->validateNonEmptyString($response, 'username', 'senderUsername', 'keyName', 'keyStatus');

		parent::__construct($response);
	}

	public function getLockId(): int
	{
		return $this->response['lockId'];
	}

	public function getUserId(): int
	{
		return $this->response['uid'];
	}

	public function getUsername(): string
	{
		return $this->response['username'];
	}

	public function getSenderUsername(): string
	{
		return $this->response['senderUsername'];
	}

	public function getKeyId(): int
	{
		return $this->response['keyId'];
	}

	public function getKeyName(): string
	{
		return $this->response['keyName'];
	}

	public function getKeyStatus(): string
	{
		return $this->response['keyStatus'];
	}

	public function getRemarks(): ?string
	{
		return $this->response['remarks'] ?: null;
	}

	public function isManagementRight(): bool
	{
		return $this->response['keyRight'] == 1;
	}

	public function isRemoteEnabled(): bool
	{
		return $this->response['remoteEnable'] == 1;
	}

	public function getStartTimeStamp(): ?int
	{
		return $this->response['startDate'] ?: null;
	}

	public function getStartDateTime(): ?DateTimeImmutable
	{
		if ($this->startDateTime === null && ($timeStamp = $this->getStartTimeStamp())) {
			$this->startDateTime = DateTime::getByUv($timeStamp);
		}

		return $this->startDateTime;
	}

	public function getEndTimeStamp(): ?int
	{
		return $this->response['endDate'] ?: null;
	}

	public function getEndDateTime(): ?DateTimeImmutable
	{
		if ($this->endDateTime === null && ($timeStamp = $this->getEndTimeStamp())) {
			$this->endDateTime = DateTime::getByUv($timeStamp);
		}

		return $this->endDateTime;
	}

	public function getSendTimeStamp(): int
	{
		return $this->response['date'];
	}

	public function getSendDateTime(): DateTimeImmutable
	{
		if ($this->sendDateTime === null) {
			$this->sendDateTime = DateTime::getByUv($this->getSendTimeStamp());
		}

		return $this->sendDateTime;
	}
}
