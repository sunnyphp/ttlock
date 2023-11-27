<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Response\Lock;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Response\Lock\GetListItemInterface;
use SunnyPHP\TTLock\Helper\DateTime;
use SunnyPHP\TTLock\Response\AbstractResponse;

final class GetListItem extends AbstractResponse implements GetListItemInterface
{
	private ?DateTimeImmutable $initializeDateTime = null;

	public function __construct(array $response)
	{
		$this->validateInteger($response, 'lockId', 'electricQuantity', 'hasGateway');
		$this->validateNonEmptyString($response, 'lockName', 'lockMac', 'featureValue', 'lockData');

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

	public function getHasGateway(): bool
	{
		return (bool) $this->response['hasGateway'];
	}

	public function getLockData(): string
	{
		return $this->response['lockData'];
	}

	public function getGroupId(): ?int
	{
		return $this->response['groupId'] ?: null;
	}

	public function getGroupName(): ?string
	{
		return $this->response['groupName'] ?: null;
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
