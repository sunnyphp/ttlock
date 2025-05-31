<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\OAuth2;

use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\OAuth2\AccessTokenInterface;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Exception\CommonException;
use Webmozart\Assert\Assert;

final class AccessToken implements AccessTokenInterface
{
	private string $username;
	private string $password;

	/**
	 * @param string $username Username to login TTLock App. Notice: do not use your platform's developer account.
	 * @param string $password Plain or MD5 hashed user password
	 * @param bool $encryptedPassword True if password hashed
	 */
	public function __construct(
		string $username,
		string $password,
		bool $encryptedPassword = false
	) {
		Assert::stringNotEmpty($username, 'Username parameter should be non-empty string');
		Assert::regex(
		    $username,
		    '~^(?:\w+|\w[\w\.-]*@[\w\.-]+\.\w+)$~',
		    'Username must contain only letters/numbers or be a valid email'
		);
		if ($encryptedPassword) {
			Assert::length($password, 32, 'Password parameter should be non-empty 32-character string (md5 hash)');
		}

		$this->username = $username;
		$this->password = $encryptedPassword ? $password : md5($password);
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function getExceptionClass(): string
	{
		return CommonException::class;
	}

	public function getRequiredConfiguration(): int
	{
		return RequiredConfiguration::CLIENT_ID | RequiredConfiguration::CLIENT_SECRET;
	}

	public function getEndpointUrl(): string
	{
		return '/oauth2/token';
	}

	public function getEndpointMethod(): string
	{
		return Method::POST;
	}

	public function getRequestParams(): array
	{
		return [
			'username' => $this->getUsername(),
			'password' => $this->getPassword(),
		];
	}
}
