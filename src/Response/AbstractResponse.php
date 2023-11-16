<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Response;

use SunnyPHP\TTLock\Contract\Response\ResponseInterface;
use Webmozart\Assert\Assert;

class AbstractResponse implements ResponseInterface
{
	protected array $response;

	public function __construct(array $response)
	{
		$this->response = $response;
	}

	protected function validateExists(array $response, string ...$keys): void
	{
		Assert::notEmpty($response, 'Empty response for validate');
		Assert::notEmpty($keys, 'Empty keys for validate');
		foreach ($keys as $key) {
			Assert::keyExists($response, $key, 'Response has no key: ' . $key);
		}
	}

	protected function validateArray(array $response, string ...$keys): void
	{
		$this->validateExists($response, ...$keys);
		foreach ($keys as $key) {
			Assert::isArray($response[$key], 'Response value in key ' . $key . ': should be array');
		}
	}

	protected function validateInteger(array $response, string ...$keys): void
	{
		$this->validateExists($response, ...$keys);
		foreach ($keys as $key) {
			Assert::integer($response[$key], 'Response value in key ' . $key . ': should be >= 1');
		}
	}

	protected function validatePositiveInteger(array $response, string ...$keys): void
	{
		$this->validateExists($response, ...$keys);
		foreach ($keys as $key) {
			Assert::positiveInteger($response[$key], 'Response value in key ' . $key . ': should be >= 1');
		}
	}

	protected function validateNonEmptyString(array $response, string ...$keys): void
	{
		$this->validateExists($response, ...$keys);
		foreach ($keys as $key) {
			Assert::stringNotEmpty($response[$key], 'Response value in key ' . $key . ': should be non-empty string');
		}
	}

	public function getArray(): array
	{
		return $this->response;
	}
}
