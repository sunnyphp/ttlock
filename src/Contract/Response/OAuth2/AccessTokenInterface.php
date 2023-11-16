<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Response\OAuth2;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Response\ResponseInterface;

interface AccessTokenInterface extends ResponseInterface
{
	public function getAccessToken(): string;

	public function getRefreshToken(): string;

	public function getUserId(): int;

	/**
	 * Expire time of access token, in second
	 * @return int
	 */
	public function getExpiresIn(): int;

	public function isExpired(?DateTimeImmutable $currentTime = null): bool;
}
