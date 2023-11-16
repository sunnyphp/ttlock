<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Exception;

/**
 * Gateway and Wi-Fi lock related errors
 * @link https://euopen.ttlock.com/document/doc?urlName=cloud/errorCodeEn.html
 */
final class GatewayException extends ApiException
{
	protected static array $codeToMessageList = [
		-2012 => 'The Lock is not connected to any Gateway.',
		-3002 => 'The gateway is offline. Please check and try again.',
		-3003 => 'The gateway is busy. Please try again later.',
		-3016 => 'Cannot Transfer Gateway(s) to Yourself.',
		-3034 => 'Network not configed. Please config the network and try again.',
		-3035 => 'Wifi lock is in power saving mode, please turn off power saving and try again.',
		-3036 => 'The lock is offline. Please check and try again.',
		-3037 => 'The lock is busy. Please try again later.',
		-4037 => 'No such Gateway exists.',
	];
}
