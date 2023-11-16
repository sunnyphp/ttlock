<?php
/** @noinspection PhpIncompatibleReturnTypeInspection */
declare(strict_types=1);

namespace SunnyPHP\TTLock;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use ReflectionClass;
use stdClass;
use SunnyPHP\TTLock\Contract\Request;
use SunnyPHP\TTLock\Contract\Response;
use SunnyPHP\TTLock\Response as R;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

/**
 * @method Response\OAuth2\AccessTokenInterface getOAuth2AccessToken(Request\OAuth2\AccessTokenInterface $request)
 * @method Response\OAuth2\RefreshAccessTokenInterface getOAuth2RefreshAccessToken(Request\OAuth2\RefreshAccessTokenInterface $request)
 * @method Response\User\GetListInterface getUserList(Request\User\GetListInterface $request)
 * @method Response\User\RegisterInterface getUserRegister(Request\User\RegisterInterface $request)
 */
final class Entrypoint
{
	private Configuration $configuration;
	private Transport $transport;
	private array $responseClass = [
		Request\OAuth2\AccessTokenInterface::class => R\OAuth2\AccessToken::class,
		Request\OAuth2\RefreshAccessTokenInterface::class => R\OAuth2\RefreshAccessToken::class,
		Request\User\GetListInterface::class => R\User\GetList::class,
		Request\User\RegisterInterface::class => R\User\Register::class,
	];

	public function __construct(
		Configuration $configuration,
		?ClientInterface $httpClient = null,
		?RequestFactoryInterface $requestFactory = null,
		array $responseClasses = []
	) {
		$this->configuration = $configuration;
		$this->transport = new Transport($configuration->getEndpointHost(), $httpClient, $requestFactory);

		if ($responseClasses !== []) {
			$this->setResponseClasses($responseClasses);
		}
	}

	public function setResponseClasses(array $responseClasses): self
	{
		foreach ($responseClasses as $requestInterface => $responseClass) {
			$this->setResponseClass($requestInterface, $responseClass);
		}

		return $this;
	}

	public function setResponseClass(string $requestInterface, string $responseClass): self
	{
		Assert::classExists($responseClass);
		Assert::subclassOf($responseClass, Response\ResponseInterface::class);

		$this->responseClass[$requestInterface] = $responseClass;

		return $this;
	}

	public function getResponse(Request\RequestInterface $request, string $responseClass): Response\ResponseInterface
	{
		$params = $request->toArray();
		if ($request->isClientCredentialsRequired()) {
			$params = array_replace($params, [
				'clientId' => $this->configuration->getClientId(),
				'clientSecret' => $this->configuration->getClientSecret(),
			]);
		}

		if ($request->getEndpointMethod() === Request\Method::POST) {
			$requestObject = $this->transport->createPostRequest($request->getEndpointUrl(), [
				'Content-Type' => 'application/x-www-form-urlencoded',
			], http_build_query($params));
		} else {
			$requestObject = $this->transport->createGetRequest($request->getEndpointUrl(), $params);
		}

		$responseArray = $this->transport->getEndpointResponse($requestObject);

		return new $responseClass($responseArray);
	}

	public function __call(string $name, array $arguments)
	{
		Assert::count($arguments, 1);
		Assert::subclassOf($arguments[0] ?? stdClass::class, Request\RequestInterface::class);

		/** @var Request\RequestInterface $request */
		$request = $arguments[0];
		$reflection = new ReflectionClass($request);
		foreach ($reflection->getInterfaceNames() as $interface) {
			if ($responseClass = ($this->responseClass[$interface] ?? null)) {
				return $this->getResponse($request, $responseClass);
			}
		}

		throw new InvalidArgumentException('Unknown response class for request class: ' . get_class($request));
	}
}
