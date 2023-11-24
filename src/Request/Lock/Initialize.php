<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\Lock;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Lock\InitializeInterface;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use Webmozart\Assert\Assert;

final class Initialize implements InitializeInterface
{
	private string $lockData;
	private ?string $lockAlias;
	private ?int $groupId;
	private ?bool $nbInitSuccess;
	private DateTimeImmutable $currentTime;

	/**
	 * @param string $lockData Lock Data, must be got from the callback function of "Lock initialize" method of APP SDK
	 * @param string|null $lockAlias Lock alias
	 * @param int|null $groupId Group ID
	 * @param bool|null $nbInitSuccess Is NB-IoT lock initialized successfully? Only NB-IoT lock need this parameter.
	 * @param DateTimeImmutable|null $currentDate Current date
	 */
	public function __construct(
		string $lockData,
		?string $lockAlias = null,
		?int $groupId = null,
		?bool $nbInitSuccess = null,
		?DateTimeImmutable $currentDate = null
	) {
		Assert::stringNotEmpty($lockData, 'Username parameter should be non-empty string');
		Assert::nullOrStringNotEmpty($lockAlias, 'Lock alias should be filled or NULL');

		$this->lockData = $lockData;
		$this->lockAlias = $lockAlias;
		$this->groupId = $groupId;
		$this->nbInitSuccess = $nbInitSuccess;
		$this->currentTime = $currentDate ?: new DateTimeImmutable();
	}

	public function getLockData(): string
	{
		return $this->lockData;
	}

	public function getLockAlias(): ?string
	{
		return $this->lockAlias;
	}

	public function getGroupId(): ?int
	{
		return $this->groupId;
	}

	public function getNbInitSuccess(): ?bool
	{
		return $this->nbInitSuccess;
	}

	public function getCurrentTime(): DateTimeImmutable
	{
		return $this->currentTime;
	}

	public function getRequiredConfiguration(): int
	{
		return RequiredConfiguration::CLIENT_ID | RequiredConfiguration::ACCESS_TOKEN;
	}

	public function getEndpointUrl(): string
	{
		return '/v3/lock/initialize';
	}

	public function getEndpointMethod(): string
	{
		return Method::POST;
	}

	public function toArray(): array
	{
		$params = [
			'lockData' => $this->getLockData(),
			'date' => $this->getCurrentTime()->getTimestamp() * 1000,
		];

		if (($value = $this->getLockAlias()) !== null) {
			$params['lockAlias'] = $value;
		}

		if (($value = $this->getGroupId()) !== null) {
			$params['groupId'] = $value;
		}

		if (($value = $this->getNbInitSuccess()) !== null) {
			$params['nbInitSuccess'] = (int) $value;
		}

		return $params;
	}
}
