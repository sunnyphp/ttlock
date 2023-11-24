<?php
/** @noinspection PhpIncompatibleReturnTypeInspection */
declare(strict_types=1);

namespace SunnyPHP\TTLock;

use ReflectionClass;
use stdClass;
use SunnyPHP\TTLock\Contract\Middleware\BeforeResponse\BeforeResponseInterface;
use SunnyPHP\TTLock\Contract\Middleware\MiddlewareInterface;
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
 * @method Response\Common\SuccessResponseInterface getUserResetPassword(Request\User\ResetPasswordInterface $request)
 * @method Response\Common\SuccessResponseInterface getUserDelete(Request\User\DeleteInterface $request)
 * @method Response\Lock\InitializeInterface getLockInitialize(Request\Lock\InitializeInterface $request)
 */
final class Entrypoint
{
	private Configuration $configuration;
	private Transport $transport;
	private Middleware $middleware;
	private array $responseClass = [
		Request\OAuth2\AccessTokenInterface::class => R\OAuth2\AccessToken::class,
		Request\OAuth2\RefreshAccessTokenInterface::class => R\OAuth2\RefreshAccessToken::class,
		Request\User\GetListInterface::class => R\User\GetList::class,
		Request\User\RegisterInterface::class => R\User\Register::class,
		Request\User\ResetPasswordInterface::class => R\Common\SuccessResponse::class,
		Request\User\DeleteInterface::class => R\Common\SuccessResponse::class,
		Request\Lock\InitializeInterface::class => R\Lock\Initialize::class,
	];

	/**
	 * @param Configuration $configuration
	 * @param Transport|null $transport
	 * @param MiddlewareInterface[] $middlewares
	 * @param array<class-string<Request\RequestInterface>, class-string<Response\ResponseInterface>> $responseClasses
	 */
	public function __construct(
		Configuration $configuration,
		?Transport $transport = null,
		array $middlewares = [],
		array $responseClasses = []
	) {
		$this->configuration = $configuration;
		$this->transport = $transport ?: new Transport();
		$this->middleware = new Middleware($middlewares);

		if ($responseClasses !== []) {
			$this->setResponseClasses($responseClasses);
		}
	}

	public function withConfiguration(Configuration $configuration): self
	{
		return new self($configuration, $this->transport, $this->middleware->getAllFlatten(), $this->responseClass);
	}

	public function withConfigurationAccessToken(string $accessToken): self
	{
		return $this->withConfiguration($this->configuration->withAccessToken($accessToken));
	}

	public function addMiddleware(MiddlewareInterface $middleware): self
	{
		$this->middleware->add($middleware);

		return $this;
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
		$url = $this->configuration->getEndpointHost() . $request->getEndpointUrl();

		$params = $request->toArray();
		if ($bitmask = $request->getRequiredConfiguration()) {
			$params = array_replace($params, $this->configuration->toArray($bitmask));
		}

		if ($request->getEndpointMethod() === Request\Method::POST) {
			$requestObject = $this->transport->createPostRequest($url, [
				'Content-Type' => 'application/x-www-form-urlencoded',
			], http_build_query($params));
		} else {
			$requestObject = $this->transport->createGetRequest($url, $params);
		}

		$responseArray = $this->transport->getEndpointResponse($requestObject);

		foreach ($this->middleware->getAllByType(BeforeResponseInterface::class) as $middleware) {
			/** @var BeforeResponseInterface $middleware */
			$responseArray = $middleware->handle($responseArray);
		}

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
