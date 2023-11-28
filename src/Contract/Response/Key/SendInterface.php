<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Response\Key;

use SunnyPHP\TTLock\Contract\Response\ResponseInterface;

interface SendInterface extends ResponseInterface
{
	/**
	 * Created key ID
	 * @return int
	 */
	public function getKeyId(): int;
}
