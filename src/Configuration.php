<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock;

use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use Webmozart\Assert\Assert;

/**
 * Entrypoint configuration
 */
final class Configuration
{
	private const ENDPOINT = 'https://euapi.ttlock.com';
	private string $clientId;
	private ?string $clientSecret;
	private ?string $accessToken;
	private string $endpointHost;
	private static array $toArrayFilter = [
		'clientId' => RequiredConfiguration::CLIENT_ID,
		'clientSecret' => RequiredConfiguration::CLIENT_SECRET,
		'accessToken' => RequiredConfiguration::ACCESS_TOKEN,
	];

	public function __construct(
		string $clientId,
		?string $clientSecret = null,
		?string $accessToken = null,
		string $endpointHost = self::ENDPOINT
	) {
		Assert::notEmpty($clientId, 'ClientId param should be filled');
		Assert::notEmpty($endpointHost, 'EndpointHost param should be filled, use default value: ' . self::ENDPOINT);

		$this->clientId = $clientId;
		$this->clientSecret = $clientSecret;
		$this->accessToken = $accessToken;
		$this->endpointHost = $endpointHost;
	}

	public function getClientId(): string
	{
		return $this->clientId;
	}

	public function getClientSecret(): ?string
	{
		return $this->clientSecret;
	}

	public function getAccessToken(): ?string
	{
		return $this->accessToken;
	}

	public function getEndpointHost(): string
	{
		return $this->endpointHost;
	}

	public function withClientId(string $clientId): self
	{
		return new self($clientId, $this->getClientSecret(), $this->getAccessToken(), $this->getEndpointHost());
	}

	public function withClientSecret(?string $clientSecret): self
	{
		return new self($this->getClientId(), $clientSecret, $this->getAccessToken(), $this->getEndpointHost());
	}

	public function withAccessToken(?string $accessToken): self
	{
		return new self($this->getClientId(), $this->getClientSecret(), $accessToken, $this->getEndpointHost());
	}

	public function withEndpointHost(string $endpointHost): self
	{
		return new self($this->getClientId(), $this->getClientSecret(), $this->getAccessToken(), $endpointHost);
	}

	public function toArray(?int $bitmask = null): array
	{
		$params = [];

		foreach (self::$toArrayFilter as $key => $filterBit) {
			if ($bitmask === null || ($bitmask & $filterBit) === $filterBit) {
				Assert::propertyExists($this, $key);

				$params[$key] = $this->{$key};
			}
		}

		return $params;
	}
}
