<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Exception;

/**
 * Lock related errors
 * @link https://euopen.ttlock.com/document/doc?urlName=cloud/errorCodeEn.html
 */
final class LockException extends ApiException
{
	protected static array $codeToMessageList = [
		-1003 => 'Lock does not exist',
		-2025 => 'Frozen lock. Can not operate on it now',
		-3011 => 'Cannot Transfer Lock(s) to Yourself',
		-4043 => 'The function is not supported for this lock',
		-4056 => 'Run out of memory',
		-4067 => 'NB Device is not registered',
		-4082 => 'Auto locking period invalid',
	];
}
