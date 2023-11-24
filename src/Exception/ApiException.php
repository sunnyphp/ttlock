<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Exception;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use Webmozart\Assert\Assert;

/**
 * @link https://euopen.ttlock.com/document/doc?urlName=cloud/errorCodeEn.html
 */
class ApiException extends Exception
{
	protected static array $codeToMessageList = [];
	protected ?ResponseInterface $response = null;

	public function __construct(string $message, int $code = 0, ?Throwable $previous = null, ?ResponseInterface $response = null)
	{
		parent::__construct($message, $code, $previous);

		$this->response = $response;
	}

	public function getResponse(): ?ResponseInterface
	{
		return $this->response;
	}

	public static function supports($content): bool
	{
		return is_array($content) && isset($content['errcode']) && $content['errcode'] != 0;
	}

	public static function createFromArray(array $content, ?ResponseInterface $response = null): self
	{
		Assert::keyExists($content, 'errmsg', 'Error array has no key "errmsg" for create exception');
		Assert::stringNotEmpty($content['errmsg'], 'Error should contains non-empty message string');

		if (isset($content['errcode'])) {
			Assert::integerish($content['errcode'], 'Error expects key "errcode" is integer-like value, got: ' . get_debug_type($content['errcode']));
		}

		return new static($content['errmsg'], (int) ($content['errcode'] ?? 0), null, $response);
	}

	public static function createWithCode(int $codeId, ?ResponseInterface $response = null): self
	{
		$message = static::$codeToMessageList[$codeId] ?? 'Unknown error (not described in API or SDK)';

		return new static($message, $codeId, null, $response);
	}
}
