<?php

namespace CartApp\User\Controller;

/**
 * UserController
 */
class UserController extends \CartApp\Core\Controller\AbstractController
{
	/** @var \CartApp\User\Mapper\UserMapper $mapper */
	protected \CartApp\User\Mapper\UserMapper $mapper;


	/**
	 * Initialize User controller
	 */
	public function initialize()
	{
		$this->mapper = new \CartApp\User\Mapper\UserMapper();
	}

	/**
	 * Return mapped collection of all users
	 *
	 * @return array
	 */
	public function listAction(): array
	{
		$users = \CartApp\User\Model\User::find();

		return $this->mapper->mapCollection($users);
	}

	/**
	 * Return mapped user by given id
	 * Throw exception if user with given id does not exist
	 *
	 * @param int $id
	 * @return array
	 * @throws \CartApp\Core\Exception\BaseException
	 */
	public function getAction(int $id): array
	{
		$user = \CartApp\User\Model\User::findFirst($id);
		if (!($user instanceof \CartApp\User\Model\User)) {
			throw new \CartApp\Core\Exception\BaseException("User with ID: $id not found.", 404);
		}

		return $this->mapper->map($user);
	}

	/**
	 * Create user from request data
	 *
	 * @return array
	 * @throws \CartApp\Core\Exception\BaseException
	 */
	public function createAction(): array
	{
		$body = $this->request->getJsonRawBody();

		$user = (new \CartApp\User\Model\User())
			->setName($body->name)
			->setSurname($body->surname)
			->setEmail($body->email)
			->setPassword($body->password);

		if ($this->user instanceof \CartApp\User\Model\User) {
			$user->setCreatedBy($this->user);
		}

		$user->save();

		return $this->mapper->map($user);
	}

	/**
	 * Update user with given id
	 * Throw exception if user with given id does not exist
	 *
	 * @param int $id
	 * @return array
	 * @throws \CartApp\Core\Exception\BaseException
	 */
	public function updateAction(int $id): array
	{
		$user = \CartApp\User\Model\User::findFirst($id);
		if (!($user instanceof \CartApp\User\Model\User)) {
			throw new \CartApp\Core\Exception\BaseException("User with ID: $id not found.", 404);
		}

		$body = $this->request->getJsonRawBody();

		$user
			->setName($body->name)
			->setSurname($body->surname)
			->setEmail($body->email)
			->setPassword($body->password)
			->setUpdatedBy($this->user);

		$user->save();

		return $this->mapper->map($user);
	}

	/**
	 * Delete user with given id
	 * Throw exception if user with given id does not exist
	 *
	 * @param int $id
	 * @return array
	 * @throws \CartApp\Core\Exception\BaseException
	 */
	public function deleteAction(int $id): array
	{
		$user = \CartApp\User\Model\User::findFirst($id);
		if (!($user instanceof \CartApp\User\Model\User)) {
			throw new \CartApp\Core\Exception\BaseException("User with ID: $id not found.", 404);
		}

		$user->delete();

		return [];
	}
}