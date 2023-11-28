<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Response\Key;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Response\Key\GetListItemInterface;
use SunnyPHP\TTLock\Helper\DateTime;
use SunnyPHP\TTLock\Response\AbstractResponse;

final class GetListItem extends AbstractResponse implements GetListItemInterface
{
	private ?DateTimeImmutable $startDateTime = null;
	private ?DateTimeImmutable $endDateTime = null;

	public function __construct(array $response)
	{
		$this->validateInteger($response, 'keyId', 'lockId', 'electricQuantity', 'startDate', 'endDate');
		$this->validateNonEmptyString($response, 'lockData', 'lockName', 'lockMac', 'featureValue');

		parent::__construct($response);
	}

	public function getKeyId(): int
	{
		return $this->response['keyId'];
	}

	public function getLockData(): string
	{
		return $this->response['lockData'];
	}

	public function getLockId(): int
	{
		return $this->response['lockId'];
	}

	public function getLockName(): string
	{
		return $this->response['lockName'];
	}

	public function getLockAlias(): ?string
	{
		return $this->response['lockAlias'] ?: null;
	}

	public function getLockMac(): string
	{
		return $this->response['lockMac'];
	}

	public function getElectricQuantity(): int
	{
		return $this->response['electricQuantity'];
	}

	public function getFeatureValue(): string
	{
		return $this->response['featureValue'];
	}

	public function getUserType(): string
	{
		return $this->response['userType'];
	}

	public function isAdminType(): bool
	{
		return $this->response['userType'] === '110301';
	}

	public function getKeyStatus(): string
	{
		return $this->response['keyStatus'];
	}

	public function getNoKeyPassword(): string
	{
		return $this->response['noKeyPwd'];
	}

	public function getGroupId(): ?int
	{
		return $this->response['groupId'] ?: null;
	}

	public function getGroupName(): ?string
	{
		return $this->response['groupName'] ?: null;
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

	public function isPassageMode(): bool
	{
		return $this->response['passageMode'] == 1;
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
}
