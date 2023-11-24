<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock\Response\User;

use SunnyPHP\TTLock\Contract\Response\User\GetListInterface;
use SunnyPHP\TTLock\Response\AbstractResponse;

final class GetList extends AbstractResponse implements GetListInterface
{
	public function __construct(array $response)
	{
		$this->validateArray($response, 'list');
		$this->validateInteger($response, 'pageSize', 'pages', 'total');
		$this->validatePositiveInteger($response, 'pageNo');

		$response['list'] = array_map(fn ($value) => new GetListItem($value), $response['list']);

		parent::__construct($response);
	}

	public function getList(): array
	{
		return $this->response['list'];
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