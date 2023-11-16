<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request\OAuth2;

use SunnyPHP\TTLock\Contract\Request\RequestInterface;

interface AccessTokenInterface extends RequestInterface
{
	/**
	 * Username to login TTLock APP or The prefixed username.
	 * Notice：please do not use your open platform's developer account.
	 * @return string
	 */
	public function getUsername(): string;

	/**
	 * Password (32 chars, low case, md5 encrypted)
	 * @return string
	 */
	public function getPassword(): string;
}
