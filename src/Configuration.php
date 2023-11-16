<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock;

use Webmozart\Assert\Assert;

/**
 * Entrypoint configuration
 */
final class Configuration
{
	private const ENDPOINT = 'https://euapi.ttlock.com';
	private string $clientId;
	private string $clientSecret;
	private string $endpointHost;

	public function __construct(
		string $clientId,
		string $clientSecret,
		string $endpointHost = self::ENDPOINT
	) {
		Assert::notEmpty($clientId, 'ClientId param should be filled');
		Assert::notEmpty($clientSecret, 'ClientSecret param should be filled');
		Assert::notEmpty($endpointHost, 'EndpointHost param should be filled, use default value: ' . self::ENDPOINT);

		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
		$this->endpointHost = $endpointHost;
	}

	public function getClientId(): string
	{
		return $this->clientId;
	}

	public function getClientSecret(): string
	{
		return $this->clientSecret;
	}

	public function getEndpointHost(): string
	{
		return $this->endpointHost;
	}

	public function withClientId(string $clientId): self
	{
		return new self($clientId, $this->getClientSecret(), $this->getEndpointHost());
	}

	public function withClientSecret(string $clientSecret): self
	{
		return new self($this->getClientId(), $clientSecret, $this->getEndpointHost());
	}

	public function withEndpointHost(string $endpointHost): self
	{
		return new self($this->getClientId(), $this->getClientSecret(), $endpointHost);
	}
}
