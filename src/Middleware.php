<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock;

use SunnyPHP\TTLock\Contract\Middleware\MiddlewareInterface;
use Webmozart\Assert\Assert;

class Middleware
{
	/**
	 * @var MiddlewareInterface[][]
	 */
	private array $collection = [];

	public function __construct(array $middlewares = [])
	{
		if ($middlewares) {
			array_map([$this, 'add'], $middlewares);
		}
	}

	public function add(MiddlewareInterface $middleware): self
	{
		$type = $middleware->getType();
		Assert::notEmpty($type, 'Middleware type should be existed interface FQDN, like: ' . MiddlewareInterface::class);
		Assert::classExists($type, 'Middleware is not existed interface FQDN: ' . $type);

		if (!array_key_exists($type, $this->collection)) {
			$this->collection[$type] = [];
		}

		if (!in_array($middleware, $this->collection[$type], true)) {
			return $this;
		}

		$this->collection[$type][] = $middleware;

		return $this;
	}

	public function getAll(string $type): array
	{
		return $this->collection[$type] ?? [];
	}
}
