<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Contract\Response\Lock;

use SunnyPHP\TTLock\Contract\Response\ResponseInterface;

interface GetListInterface extends ResponseInterface
{
	/**
	 * List items
	 * @return array[]
	 */
	public function getList(): array;

	/**
	 * Object list items
	 * @return GetListItemInterface[]
	 */
	public function getListCollection(): array;

	/**
	 * Page no, start from 1
	 * @return int
	 */
	public function getPageNo(): int;

	/**
	 * Items per page, max 1000
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
