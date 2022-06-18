<?php

namespace CartApp\Core\Controller;

/**
 * AbstractSecureController
 */
abstract class AbstractController extends \Phalcon\Mvc\Controller
{
	/** @var \CartApp\User\Model\User|null $user */
	protected ?\CartApp\User\Model\User $user = null;


	/**
	 * @param \Phalcon\Mvc\Dispatcher $dispatcher
	 */
	public function beforeExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher)
	{
		$this->authenticate();
	}

	/**
	 * @param \Phalcon\Mvc\Dispatcher $dispatcher
	 */
	public function afterExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher)
	{
		$this->response->setStatusCode(200);
		$this->response->setJsonContent([
			'version' => \CartApp\Core\Application\Application::VERSION,
			'error' => false,
			'data' => $dispatcher->getReturnedValue(),
		])->send();
	}

	/**
	 * Authenticate user by api key
	 */
	public function authenticate()
	{
		$headers = getallheaders();

		if (!isset($headers['Authorization']) && !isset($headers['authorization'])) {
			throw new \CartApp\Core\Exception\BaseException("Authorization header missing", 400);
		}

		$authorizationHeader = (isset($headers['Authorization'])) ? $headers['Authorization'] : $headers['authorization'];

		$apiKey = '';
		$matches = [];
		if (preg_match("/Basic ([0-9a-zA-Z]*)/", $authorizationHeader, $matches)) {
			$apiKey = $matches[1];
		}

		if (empty($apiKey)) {
			throw new \CartApp\Core\Exception\BaseException("ApiKey is missing from request headers", 401);
		}

		$user = \CartApp\User\Model\User::findByApiKey($apiKey);

		if (!($user instanceof \CartApp\User\Model\User)) {
			throw new \CartApp\Core\Exception\BaseException("Authenticating failed", 401);
		}

		$this->user = $user;
	}
}