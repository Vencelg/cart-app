<?php

namespace CartApp\User\Controller;

use CartApp\Core\Exception\BaseException;
use CartApp\User\Validator\CreateActionValidator;
use CartApp\User\Validator\UpdateActionValidator;

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
     * Return mapped user by given apiKey
     *
     * @return array
     */
    public function userAction(): array
    {
        $headers = $this->request->getHeaders();
        $apiKey = explode(" ", $headers['Authorization']);
        $apiKey = $apiKey[1];

        $user = \CartApp\User\Model\User::findByApiKey($apiKey);

        return $this->mapper->map($user);
    }

    /**
     * Return mapped user by given apiKey
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

/*        $di = $this->getDI()->getShared(\CartApp\Core\Service\MqttService::class);
        $di->publish("user/".$id, "xadas");*/

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
        $validator = new CreateActionValidator([
            'name' => $body->name,
            'surname' => $body->surname,
            'email' => $body->email,
            'password' => $body->password,
            'gender' => $body->gender,
            'age' => $body->age,
        ]);
        $validation = $validator->validate();

        if ($validation['errorsSet']) {
            throw new BaseException($validation['messages'], 422);
        }

        $user = (new \CartApp\User\Model\User())
            ->setName($body->name)
            ->setSurname($body->surname)
            ->setEmail($body->email)
            ->setPassword($body->password)
            ->setGender($body->gender)
            ->setAge($body->age)
            ->setProfilePicture(null);

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
        $body = $this->request->getJsonRawBody();

        $validator = new UpdateActionValidator([
            'name' => $body->name,
            'surname' => $body->surname,
            'gender' => $body->gender,
            'age' => $body->age,
            'profile_picture' => $body->profile_picture
        ]);

        $validation = $validator->validate();
        if ($validation['errorsSet']) {
            throw new BaseException($validation['messages'], 422);
        }

        $user = \CartApp\User\Model\User::findFirst($id);
        if (!($user instanceof \CartApp\User\Model\User)) {
            throw new \CartApp\Core\Exception\BaseException("User with ID: $id not found.", 404);
        }

        $user
            ->setName($body->name ?? $user->getName())
            ->setSurname($body->surname ?? $user->getSurname())
            ->setGender($body->gender ?? $user->getGender())
            ->setAge($body->age ?? $user->getAge())
            ->setProfilePicture($body->profile_picture ?? $user->getProfilePicture())
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