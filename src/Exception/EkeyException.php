<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Exception;

/**
 * Ekey related errors
 * @link https://euopen.ttlock.com/document/doc?urlName=cloud/errorCodeEn.html
 */
final class EkeyException extends ApiException
{
	protected static array $codeToMessageList = [
		-1008 => 'eKey does not exist',
		-1016 => 'An identical Name exists. Please choose a different Name.',
		-1018 => 'This Group does not exist',
		-1027 => 'Cant send eKey to this account which has been bound to another account',
		-2019 => 'You cannot send an eKey to Yourself',
		-2020 => 'You cannot send an eKey to the Admin',
		-2023 => 'Can\'t change the time period now',
		-4064 => 'Failed. The eKey can only be sent to a registered account',
	];
}
