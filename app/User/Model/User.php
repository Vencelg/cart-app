<?php

namespace CartApp\User\Model;

/**
 * Class User
 */
class User extends \CartApp\Core\Model\AbstractModel
{
    use \CartApp\Core\Model\IdTrait;
    use \CartApp\Core\Model\CudLogTrait;

    /** @var string $name */
    protected $name;

    /** @var string $surname */
    protected $surname;

    /** @var string $email */
    protected $email;

    /** @var string $password */
    protected $password;

    /** @var string $api_key */
    protected $api_key;

    /**
     * @var string $gender
     */
    protected string $gender;

    /**
     * @var int
     */
    protected int $age;

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     * @return User
     */
    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getProfilePicture(): ?string
    {
        return $this->profile_picture;
    }

    /**
     * @param null|string $profile_picture
     * @return User
     */
    public function setProfilePicture(?string $profile_picture): self
    {
        $this->profile_picture = $profile_picture;

        return $this;
    }

    /**
     * @var null|string
     */
    protected ?string $profile_picture;

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return User
     */
    public function setGender(string $gender): self
    {
        $this->gender = $gender;
        return $this;
    }


    /** @inheritDoc */
    public function initialize()
    {
        $this->setSchema('cart_app');
        $this->setSource('user');
        $this->initCudLog();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return self
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return self
     */
    public function setSurname($surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return self
     */
    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return self
     */
    public function setPassword($password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->api_key;
    }

    /**
     * @param string $apiKey
     * @return self
     */
    public function setApiKey($apiKey): self
    {
        $this->api_key = $apiKey;
        return $this;
    }

    /**
     * Find user by api key
     *
     * @param string $apiKey
     * @return \Phalcon\Mvc\ModelInterface|null
     */
    public static function findByApiKey(string $apiKey)
    {
        return self::findFirst([
            'conditions' => 'api_key = ?1',
            'bind' => [
                1 => $apiKey,
            ]
        ]);
    }

    /**
     * Find user by email
     *
     * @param string $email
     * @return \Phalcon\Mvc\ModelInterface|null
     */
    public static function findByEmail(string $email)
    {
        return self::findFirst([
            'conditions' => 'email = ?1',
            'bind' => [
                1 => $email,
            ]
        ]);
    }

    /**
     * Before user create
     */
    public function beforeCreate()
    {
        $this->setApiKey(\Nette\Utils\Random::generate(32, '0-9a-zA-Z'));
    }

    /**
     * Before user save
     */
    public function beforeSave()
    {
        $this->setPassword(password_hash($this->getPassword(), PASSWORD_BCRYPT, ['cost' => 12]));
    }

    /**
     * User validation
     *
     * @return bool
     */
    public function validation()
    {
        $validator = new \Phalcon\Validation();

        $validator->add(
            [
                'name',
                'surname',
                'email',
                'password',
            ],
            new \Phalcon\Validation\Validator\PresenceOf(
                [
                    'message' => [
                        'name' => 'The user name is required',
                        'surname' => 'The user surname is required',
                        'email' => 'The user email is required',
                        'password' => 'The user password is required',
                    ],
                ]
            )
        );

        $validator->add(
            'email',
            new \Phalcon\Validation\Validator\Email(
                [
                    'message' => 'The user email is not valid',
                ]
            )
        );

        $validator->add(
            'email',
            new \Phalcon\Validation\Validator\Uniqueness(
                [
                    'message' => 'The user email already exists',
                ]
            )
        );

        return $this->validate($validator);
    }
}