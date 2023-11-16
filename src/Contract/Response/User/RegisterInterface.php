<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Response\User;

use SunnyPHP\TTLock\Contract\Response\ResponseInterface;

interface RegisterInterface extends ResponseInterface
{
	/**
	 * Prefixed username
	 * @return string
	 */
	public function getUsername(): string;
}
