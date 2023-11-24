<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Middleware\BeforeResponse;

use SunnyPHP\TTLock\Contract\Middleware\MiddlewareInterface;

interface BeforeResponseInterface extends MiddlewareInterface
{
	public function handle(array $response, ?MiddlewareInterface $next = null): array;
}
