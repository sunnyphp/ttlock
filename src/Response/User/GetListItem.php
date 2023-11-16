<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Response\User;

use SunnyPHP\TTLock\Contract\Response\User\GetListItemInterface;
use SunnyPHP\TTLock\Response\AbstractResponse;

final class GetListItem extends AbstractResponse implements GetListItemInterface
{
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

	public function getRegTime(): int
	{
		return $this->response['regtime'];
	}
}
