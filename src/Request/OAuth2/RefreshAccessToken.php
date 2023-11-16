<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\OAuth2;

use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\OAuth2\RefreshAccessTokenInterface;
use Webmozart\Assert\Assert;

final class RefreshAccessToken implements RefreshAccessTokenInterface
{
	private string $refreshToken;
	private string $grantType;

	/**
	 * @param string $refreshToken Username to login TTLock App. Notice: do not use your platform's developer account.
	 * @param string $grantType Grant type, `refresh_token` by default
	 */
	public function __construct(
		string $refreshToken,
		string $grantType = 'refresh_token'
	) {
		Assert::notEmpty($refreshToken, 'Refresh token parameter should be non-empty string');
		Assert::notEmpty($grantType, 'Grant type parameter should be non-empty string');

		$this->refreshToken = $refreshToken;
		$this->grantType = $grantType;
	}

	public function getRefreshToken(): string
	{
		return $this->refreshToken;
	}

	public function getGrantType(): string
	{
		return $this->grantType;
	}

	public function isClientCredentialsRequired(): bool
	{
		return true;
	}

	public function getEndpointUrl(): string
	{
		return '/oauth2/token';
	}

	public function getEndpointMethod(): string
	{
		return Method::POST;
	}

	public function toArray(): array
	{
		return [
			'refresh_token' => $this->getRefreshToken(),
			'grant_type' => $this->getGrantType(),
		];
	}
}
