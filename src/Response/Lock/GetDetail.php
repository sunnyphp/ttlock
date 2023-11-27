<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Response\Lock;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Response\Lock\GetDetailInterface;
use SunnyPHP\TTLock\Helper\DateTime;
use SunnyPHP\TTLock\Response\AbstractResponse;

final class GetDetail extends AbstractResponse implements GetDetailInterface
{
	private ?DateTimeImmutable $initializeDateTime = null;

	public function __construct(array $response)
	{
		$this->validateInteger($response, 'lockId', 'electricQuantity', 'date');

		parent::__construct($response);
	}

	public function getLockId(): int
	{
		return $this->response['lockId'];
	}

	public function getLockName(): string
	{
		return $this->response['lockName'];
	}

	public function getLockAlias(): string
	{
		return $this->response['lockAlias'];
	}

	public function getLockMac(): string
	{
		return $this->response['lockMac'];
	}

	public function getNoKeyPassword(): string
	{
		return $this->response['noKeyPwd'];
	}

	public function getElectricQuantity(): int
	{
		return $this->response['electricQuantity'];
	}

	public function getFeatureValue(): string
	{
		return $this->response['featureValue'];
	}

	public function getTimeZoneRawOffset(): int
	{
		return $this->response['timezoneRawOffset'];
	}

	public function getModelNumber(): string
	{
		return $this->response['modelNum'];
	}

	public function getHardwareRevision(): string
	{
		return $this->response['hardwareRevision'];
	}

	public function getFirmwareRevision(): string
	{
		return $this->response['firmwareRevision'];
	}

	public function getAutoLockTime(): int
	{
		return $this->response['autoLockTime'];
	}

	public function getLockSound(): int
	{
		return $this->response['lockSound'];
	}

	public function getPrivacyLock(): int
	{
		return $this->response['privacyLock'];
	}

	public function getTamperAlert(): int
	{
		return $this->response['tamperAlert'];
	}

	public function getResetButton(): int
	{
		return $this->response['resetButton'];
	}

	public function getOpenDirection(): int
	{
		return $this->response['openDirection'];
	}

	public function getPassageMode(): int
	{
		return $this->response['passageMode'];
	}

	public function getPassageModeAutoUnlock(): int
	{
		return $this->response['passageModeAutoUnlock'];
	}

	public function getInitializeTimeStamp(): int
	{
		return $this->response['date'];
	}

	public function getInitializeDateTime(): DateTimeImmutable
	{
		if ($this->initializeDateTime === null) {
			$this->initializeDateTime = DateTime::getByUv($this->getInitializeTimeStamp());
		}

		return $this->initializeDateTime;
	}
}
