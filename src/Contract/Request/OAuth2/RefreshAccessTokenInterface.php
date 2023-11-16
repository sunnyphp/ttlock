<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request\OAuth2;

use SunnyPHP\TTLock\Contract\Request\RequestInterface;

interface RefreshAccessTokenInterface extends RequestInterface
{
	public function getRefreshToken(): string;

	/**
	 * Grant type, `refresh_token` by default
	 * @return string
	 */
	public function getGrantType(): string;
}
