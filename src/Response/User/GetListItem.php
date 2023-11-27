<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Response\User;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Response\User\GetListItemInterface;
use SunnyPHP\TTLock\Helper\DateTime;
use SunnyPHP\TTLock\Response\AbstractResponse;

final class GetListItem extends AbstractResponse implements GetListItemInterface
{
	private ?DateTimeImmutable $registerDateTime = null;

	public function __construct(array $response)
	{
		$this->validateNonEmptyString($response, 'username');
		$this->validatePositiveInteger($response, 'regtime');

		parent::__construct($response);
	}

	public function getUsername(): string
	{
		return $this->response['username'];
	}

	public function getRegisterTimeStamp(): int
	{
		return $this->response['regtime'];
	}

	public function getRegisterDateTime(): DateTimeImmutable
	{
		if ($this->registerDateTime === null) {
			$this->registerDateTime = DateTime::getByUv($this->getRegisterTimeStamp());
		}

		return $this->registerDateTime;
	}
}
