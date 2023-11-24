<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Middleware;

interface MiddlewareInterface
{
	/**
	 * @return class-string
	 */
	public function getType(): string;
}
