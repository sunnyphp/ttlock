<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Response\Lock;

use SunnyPHP\TTLock\Contract\Response\Lock\InitializeInterface;
use SunnyPHP\TTLock\Response\AbstractResponse;

final class Initialize extends AbstractResponse implements InitializeInterface
{
	public function __construct(array $response)
	{
		$this->validatePositiveInteger($response, 'lockId', 'keyId');

		parent::__construct($response);
	}

	public function getLockId(): int
	{
		return $this->response['lockId'];
	}

	public function getKeyId(): int
	{
		return $this->response['keyId'];
	}
}
