<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Request\Lock;

use DateTimeImmutable;
use SunnyPHP\TTLock\Contract\Request\RequestInterface;

interface InitializeInterface extends RequestInterface
{
	public function getLockData(): string;

	public function getLockAlias(): ?string;

	public function getGroupId(): ?int;

	public function getNbInitSuccess(): ?bool;

	public function getCurrentTime(): DateTimeImmutable;
}
