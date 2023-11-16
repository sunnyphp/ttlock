<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Response\OAuth2;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Response\OAuth2\RefreshAccessTokenInterface;
use SunnyPHP\TTLock\Response\AbstractResponse;

final class RefreshAccessToken extends AbstractResponse implements RefreshAccessTokenInterface
{
	private DateTimeImmutable $created;

	public function __construct(array $response)
	{
		$this->validateNonEmptyString($response, 'access_token', 'refresh_token');
		$this->validatePositiveInteger($response, 'expires_in');

		$this->created = new DateTimeImmutable();

		parent::__construct($response);
	}

	public function getAccessToken(): string
	{
		return $this->response['access_token'];
	}

	public function getRefreshToken(): string
	{
		return $this->response['refresh_token'];
	}

	public function getExpiresIn(): int
	{
		return $this->response['expires_in'];
	}

	public function isExpired(?DateTimeImmutable $currentTime = null): bool
	{
		$currentTime = $currentTime ?: new DateTimeImmutable();

		return $currentTime->getTimestamp() >= $this->created->getTimestamp() + $this->getExpiresIn();
	}
}
