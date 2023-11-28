<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Response\Key;

use SunnyPHP\TTLock\Contract\Response\Key\GetListByLockInterface;
use SunnyPHP\TTLock\Response\AbstractResponse;

final class GetListByLock extends AbstractResponse implements GetListByLockInterface
{
	private ?array $collection = null;

	public function __construct(array $response)
	{
		$this->validateArray($response, 'list');
		$this->validateInteger($response, 'pageSize', 'pages', 'total');
		$this->validatePositiveInteger($response, 'pageNo');

		parent::__construct($response);
	}

	public function getList(): array
	{
		return $this->response['list'];
	}

	public function getListCollection(): array
	{
		if ($this->collection === null) {
			$this->collection = array_map(fn ($value) => new GetListByLockItem($value), $this->getList());
		}

		return $this->collection;
	}

	public function getPageNo(): int
	{
		return $this->response['pageNo'];
	}

	public function getPageSize(): int
	{
		return $this->response['pageSize'];
	}

	public function getPages(): int
	{
		return $this->response['pages'];
	}

	public function getTotal(): int
	{
		return $this->response['total'];
	}
}
