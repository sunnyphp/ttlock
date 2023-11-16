<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Response\User;

use SunnyPHP\TTLock\Contract\Response\User\RegisterInterface;
use SunnyPHP\TTLock\Response\AbstractResponse;

final class Register extends AbstractResponse implements RegisterInterface
{
	public function __construct(array $response)
	{
		$this->validateNonEmptyString($response, 'username');

		parent::__construct($response);
	}

	public function getUsername(): string
	{
		return $this->response['username'];
	}
}
