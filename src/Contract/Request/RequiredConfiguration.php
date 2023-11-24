<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request;

final class RequiredConfiguration
{
	public const CLIENT_ID = 1 << 0;
	public const CLIENT_SECRET = 1 << 1;
	public const ACCESS_TOKEN = 1 << 2;
}
