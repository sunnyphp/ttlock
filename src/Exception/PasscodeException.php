<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Exception;

/**
 * Passcode related errors
 * @link https://euopen.ttlock.com/document/doc?urlName=cloud/errorCodeEn.html
 */
final class PasscodeException extends ApiException
{
	protected static array $codeToMessageList = [
		-1007 => 'No password data of this lock',
		-2009 => 'Invalid Password',
		-3006 => 'Invalid Passcode. Passcode should be between 6 - 9 Digits in length',
		-3007 => 'The same passcode already exists. Please use another one',
		-3008 => 'A Passcode that has never been used on the Lock cannot be changed',
		-3009 => 'There is NO SPACE to store Customized Passcodes. Please Delete Un-Used Customized Passcodes and try again',
	];
}
