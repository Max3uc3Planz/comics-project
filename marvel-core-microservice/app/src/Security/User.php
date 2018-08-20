<?php
/**
 * Created by PhpStorm.
 * User: KxF
 * Date: 01/02/2018
 * Time: 14:49
 */

namespace App\Security;


use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

class User implements JWTUserInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var array
     */
    private $roles;


    /**
     * User constructor.
     * @param array $payload
     */
    public function __construct(array $payload)
    {
        $this->id = $payload['id'];
        $this->roles = $payload['roles'];
    }


    /**
     * Creates a new instance from a given JWT payload.
     *
     * @param string $username
     * @param array $payload
     *
     * @return JWTUserInterface
     */
    public static function createFromPayload($username, array $payload)
    {
        return new User($payload);
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCompany(): ?int
    {
        return $this->company_id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}