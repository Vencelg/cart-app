<?php

namespace CartApp\User\Controller;

/**
 * UserUnsecureController
 */
class UserUnsecureController extends \CartApp\User\Controller\UserController
{
	/**
	 * Turn off authentication
	 */
	public function authenticate()
	{
	}

	/**
	 * Register (create) user from request data
	 *
	 * @return array
	 */
	public function registerAction(): array
	{
		return parent::createAction();
	}

	/**
	 * Log in user by email and password
	 *
	 * @throws \CartApp\Core\Exception\BaseException
	 */
	public function loginAction()
	{
		$body = $this->request->getJsonRawBody();

		if (!isset($body->email) || empty($body->email)) {
			throw new \CartApp\Core\Exception\BaseException('Email is required', 400);
		}

		if (!isset($body->password) || empty($body->password)) {
			throw new \CartApp\Core\Exception\BaseException('Password is required', 400);
		}

		$user = \CartApp\User\Model\User::findByEmail($body->email);
		if (!($user instanceof \CartApp\User\Model\User)) {
			throw new \CartApp\Core\Exception\BaseException('Wrong email ' . $body->email, 401);
		}

		if (!password_verify($body->password, $user->getPassword())) {
			throw new \CartApp\Core\Exception\BaseException('Wrong password for user with email ' . $body->email, 401);
		}

		$this->mapper->setIncludeApiKey(true);
		return $this->mapper->map($user);
	}
}