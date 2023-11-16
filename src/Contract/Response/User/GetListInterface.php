<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Response\User;

use SunnyPHP\TTLock\Contract\Response\ResponseInterface;

interface GetListInterface extends ResponseInterface
{
	/**
	 * List items
	 * @return GetListItemInterface[]
	 */
	public function getList(): array;

	/**
	 * Page no, start from 1
	 * @return int
	 */
	public function getPageNo(): int;

	/**
	 * Items per page, max 100
	 * @return int
	 */
	public function getPageSize(): int;

	/**
	 * Total number of pages
	 * @return int
	 */
	public function getPages(): int;

	/**
	 * Total number of records
	 * @return int
	 */
	public function getTotal(): int;
}
