<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Response\Lock;

use SunnyPHP\TTLock\Contract\Response\ResponseInterface;

interface InitializeInterface extends ResponseInterface
{
	public function getLockId(): int;

	public function getKeyId(): int;
}
