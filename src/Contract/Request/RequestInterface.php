<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request;

interface RequestInterface
{
	/**
	 * Returns class FQDN for exceptions
	 * @return class-string
	 */
	public function getExceptionClass(): string;

	/**
	 * Returns required configuration bitmask
	 * @return int
	 */
	public function getRequiredConfiguration(): int;

	/**
	 * Endpoint request URL part
	 * @return string
	 */
	public function getEndpointUrl(): string;

	/**
	 * Endpoint request method
	 * @return string
	 */
	public function getEndpointMethod(): string;

	/**
	 * Returns key-value array for pass into endpoint request params
	 * @return array
	 */
	public function getRequestParams(): array;
}
