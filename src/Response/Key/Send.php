<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Response\Key;

use SunnyPHP\TTLock\Contract\Response\Key\SendInterface;
use SunnyPHP\TTLock\Response\AbstractResponse;

final class Send extends AbstractResponse implements SendInterface
{
	public function __construct(array $response)
	{
		$this->validatePositiveInteger($response, 'keyId');

		parent::__construct($response);
	}

	public function getKeyId(): int
	{
		return $this->response['keyId'];
	}
}
