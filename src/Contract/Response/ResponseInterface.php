<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Response;

interface ResponseInterface
{
	/**
	 * Constructor accepts raw response array
	 * @param array $response
	 */
	public function __construct(array $response);

	/**
	 * Returns raw response array
	 * @return array
	 */
	public function getResponseArray(): array;
}
