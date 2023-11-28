<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Request\User;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\Method;
use SunnyPHP\TTLock\Contract\Request\RequiredConfiguration;
use SunnyPHP\TTLock\Contract\Request\User\ResetPasswordInterface;
use SunnyPHP\TTLock\Exception\CommonException;
use SunnyPHP\TTLock\Helper\DateTime;
use Webmozart\Assert\Assert;

final class ResetPassword implements ResetPasswordInterface
{
	private string $username;
	private string $password;
	private DateTimeImmutable $currentDateTime;

	/**
	 * @param string $username Username for reset password in API. Notice: do not use your platform's developer account.
	 * @param string $password Plain or MD5 hashed user password
	 * @param bool $encryptedPassword True if password hashed
	 * @param DateTimeImmutable|null $currentDateTime Current date
	 */
	public function __construct(
		string $username,
		string $password,
		bool $encryptedPassword = false,
		?DateTimeImmutable $currentDateTime = null
	) {
		Assert::stringNotEmpty($username, 'Username parameter should be non-empty string');
		Assert::regex($username, '~^\w+$~', 'Username should contain only english characters or/and numbers');
		if ($encryptedPassword) {
			Assert::length($password, 32, 'Password parameter should be non-empty 32-character string (md5 hash)');
		}

		$this->username = $username;
		$this->password = $encryptedPassword ? $password : md5($password);
		$this->currentDateTime = $currentDateTime ?: new DateTimeImmutable();
	}

	public function getUsername(): string
	{
		return $this->username;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function getCurrentTimeStamp(): int
	{
		return DateTime::getUv($this->getCurrentDateTime());
	}

	public function getCurrentDateTime(): DateTimeImmutable
	{
		return $this->currentDateTime;
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
		return '/v3/user/resetPassword';
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
			'date' => $this->getCurrentTimeStamp(),
		];
	}
}
