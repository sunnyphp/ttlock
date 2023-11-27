<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Helper;

use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

final class DateTime
{
	private static ?DateTimeZone $utc = null;

	public static function getTimeZone(): DateTimeZone
	{
		if (self::$utc === null) {
			self::$utc = new DateTimeZone('UTC');
		}

		return self::$utc;
	}

	private static function getLastError(): ?string
	{
		if ($error = DateTimeImmutable::getLastErrors()) {
			return implode(', ', $error['errors'] ?? []) ?: null;
		}

		return null;
	}

	public static function getByUv(int $timeStamp): DateTimeImmutable
	{
		$timeStamp = substr((string) $timeStamp, 0, -3) . '-' . substr((string) $timeStamp, -3);
		$dateTime = DateTimeImmutable::createFromFormat('!U-v', $timeStamp, self::getTimeZone());
		if (!$dateTime) {
			$message = 'Cannot parse unix time stamp with milliseconds format: ' . $timeStamp;
			if ($error = self::getLastError()) {
				$message .= ', (' . $error . ')';
			}

			throw new InvalidArgumentException($message);
		}

		return $dateTime;
	}

	public static function getUv(DateTimeInterface $dateTime): int
	{
		return (int) $dateTime->format('Uv');
	}

	public static function getUvOrNull(?DateTimeInterface $dateTime): ?int
	{
		if ($dateTime === null) {
			return null;
		}

		return self::getUv($dateTime);
	}
}
