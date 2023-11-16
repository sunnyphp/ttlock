<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Exception;

/**
 * Account, Rights and common errors
 * @link https://euopen.ttlock.com/document/doc?urlName=cloud/errorCodeEn.html
 */
final class CommonException extends ApiException
{
	protected static array $codeToMessageList = [
		1 => 'failed or means no',
		10000 => 'invalid client_id',
		10001 => 'invalid client',
		10003 => 'invalid token',
		10004 => 'invalid grant',
		10007 => 'invalid account or invalid password',
		10011 => 'invalid refresh_token',
		20002 => 'not lock admin',
		30002 => 'invalid username, only English character and digits is allowed',
		30003 => 'existing registered users',
		30004 => 'invalid userid to delete',
		30005 => 'password must be md5 encrypted',
		30006 => 'exceeds the restrictions of API call number',
		80000 => 'date must be current time, in 5 minutes',
		80002 => 'invalid json format',
		90000 => 'internal server error',
		-3 => 'Invalid Parameter',
		-2018 => 'Permission Denied',
		-4063 => 'Please delete/transfer all yours locks first',
	];
}
