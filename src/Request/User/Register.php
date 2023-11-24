<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\User;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Contract\Request\User\RegisterInterface;
use Webmozart\Assert\Assert;

final class Register implements RegisterInterface
{
	private string $username;
	private string $password;
	private DateTimeImmutable $currentTime;

	/**
	 * @param string $username Username for registration in API. Notice: do not use your platform's developer account.
	 * @param string $password Plain or MD5 hashed user password
	 * @param bool $encryptedPassword True if password hashed
	 * @param DateTimeImmutable|null $currentDate Current date
	 */
	public function __construct(
		string $username,
		string $password,
		bool $encryptedPassword = false,
		?DateTimeImmutable $currentDate = null
	) {
		Assert::stringNotEmpty($username, 'Username parameter should be non-empty string');
		Assert::regex($username, '~^\w+$~', 'Username should contain only english characters or/and numbers');
		if ($encryptedPassword) {
			Assert::length($password, 32, 'Password parameter should be non-empty 32-character string (md5 hash)');
		}

		$this->username = $username;
		$this->password = $encryptedPassword ? $password : md5($password);
		$this->currentTime = $currentDate ?: new DateTimeImmutable();
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function getCurrentTime(): DateTimeImmutable
	{
		return $this->currentTime;
	}

	public function getRequiredConfiguration(): int
	{
		return RequiredConfiguration::CLIENT_ID | RequiredConfiguration::CLIENT_SECRET;
	}

	public function getEndpointUrl(): string
	{
		return '/v3/user/register';
	}

	public function getEndpointMethod(): string
	{
		return Method::POST;
	}

	public function toArray(): array
	{
		return [
			'username' => $this->getUsername(),
			'password' => $this->getPassword(),
			'date' => $this->getCurrentTime()->getTimestamp() * 1000,
		];
	}
}
