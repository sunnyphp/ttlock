<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request;

interface RequestInterface
{
	/**
	 * Returns True if client credentials required (clientId, clientSecret)
	 * @return bool
	 */
	public function isClientCredentialsRequired(): bool;

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
	public function toArray(): array;
}
