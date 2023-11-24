<?php
declare(strict_types=1);

namespace SunnyPHP\TTLock;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use SunnyPHP\TTLock\Exception\ApiException;
use Throwable;

final class Transport
{
	private ClientInterface $httpClient;
	private RequestFactoryInterface $requestFactory;
	private StreamFactoryInterface $streamFactory;

	public function __construct(
		?ClientInterface $httpClient = null,
		?RequestFactoryInterface $requestFactory = null,
		?StreamFactoryInterface $streamFactory = null
	) {
		$this->httpClient = $httpClient ?: Psr18ClientDiscovery::find();
		$this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
		$this->streamFactory = $streamFactory ?: Psr17FactoryDiscovery::findStreamFactory();
	}

	/**
	 * @param string $url
	 * @param array $headers
	 * @return RequestInterface
	 * @see RequestFactoryInterface::createRequest()
	 */
	public function createPostRequest(string $url, array $headers = [], ?string $body = null): RequestInterface
	{
		$request = $this->requestFactory->createRequest('POST', $url);
		foreach ($headers as $name => $values) {
			$request = $request->withHeader($name, $values);
		}

		if ($body !== null) {
			$request = $request->withBody($this->streamFactory->createStream($body));
		}

		return $request;
	}

	public function createGetRequest(string $url, array $queryParams = [], array $headers = []): RequestInterface
	{
		$url .= ($queryParams ? (str_contains($url, '?') ? '&' : '?') . http_build_query($queryParams) : '');

		$request = $this->requestFactory->createRequest('GET', $url);
		foreach ($headers as $name => $values) {
			$request = $request->withHeader($name, $values);
		}

		return $request;
	}

	private function getResponseContentType(ResponseInterface $response): ?string
	{
		if (is_array($contentTypes = $response->getHeader('Content-Type')) && $contentTypes) {
			if ($contentType = current($contentTypes)) {
				// cutoff charset
				if (str_contains($contentType, ';')) {
					$exploded = array_map('trim', explode(';', $contentType));
					$contentType = current($exploded);
				}

				return $contentType;
			}
		}

		return null;
	}

	/**
	 * Returns API response (json decoded) or exception
	 * @param RequestInterface $request
	 * @return array
	 * @throws ApiException
	 * @throws Throwable
	 */
	public function getEndpointResponse(RequestInterface $request): array
	{
		$response = null;
		try {
			$response = $this->httpClient->sendRequest($request);
			if (!($type = $this->getResponseContentType($response)) || !str_contains($type, 'application/json')) {
				$message = 'Unsupported response content type: ' . $type;
				if (str_contains($type, 'text/html')) {
					$content = trim(preg_replace('~[\n\t]+|\s{2,}~', ' ', strip_tags($response->getBody()->getContents())), " .\t\n");
					$message .= ', content: ' . htmlspecialchars($content) . '.';
				}

				throw new ApiException($message);
			}

			$content = $response->getBody()->getContents();
			$content = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

			if (!is_array($content)) {
				throw new ApiException('Unknown response content type: ' . get_debug_type($content), 0, null, $response);
			} elseif (ApiException::supports($content)) {
				throw ApiException::createFromArray($content, $response);
			}

			return $content;
		} catch (Throwable $e) {
			if (!$e instanceof ApiException) {
				$e = new ApiException($e->getMessage(), $e->getCode(), $e, $response ?: null);
			}

			throw $e;
		}
	}
}
