<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Response\OAuth2;

use SunnyPHP\TTLock\Contract\Response\ResponseInterface;

interface RefreshAccessTokenInterface extends ResponseInterface
{
	public function getAccessToken(): string;

	public function getRefreshToken(): string;

	/**
	 * Expire time of access token, in second
	 * @return int
	 */
	public function getExpiresIn(): int;
}
