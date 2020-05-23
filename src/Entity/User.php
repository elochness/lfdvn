<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="UNIQ_email", columns={"email"})})
 * @ORM\Entity
 * @UniqueEntity(fields={"username"}, message="user.email.exist")
 */
class User implements UserInterface, Serializable
{
    /**
     * Name of user role.
     *
     * @var string
     */
    const ROLE_USER = 'ROLE_USER';

    /**
     * Name of admin role.
     *
     * @var string
     */
    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * User ID
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * Username
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false, unique=true)
     * @Assert\NotBlank(message="user.email.not_blank")
     * @Assert\Email(message = "user.email.not_email")
     */
    private $username;

    /**
     * Password of the user
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="json", length=0, nullable=false)
     */
    private $roles;

    /**
     * First name of the user
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="user.first_name.not_blank")
     */
    private $firstName;

    /**
     * Last name of the user
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="user.last_name.not_blank")
     */
    private $lastName;

    /**
     * Phone of the user
     * @var string|null
     *
     * @ORM\Column(name="phone", type="string", length=20, nullable=true)
     * @Assert\NotBlank(message="user.phone.not_blank")
     */
    private $phone;

    /**
     * Indication whether the user is activated
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=false)
     */
    private $enabled;

    /**
     * List of product order of the user
     * @var ProductOrder[]
     *
     * @ORM\OneToMany(targetEntity="ProductOrder", mappedBy="user", cascade={"remove"})
     */
    private $productOrders;

    /**
     * Constructor of the user class.
     * (Initialize some fields).
     */
    public function __construct()
    {
        $this->productOrders = new ArrayCollection();
        $this->roles = [User::ROLE_USER];
        $this->enabled = true;
    }

    /**
     * Get user ID
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get email of the user
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set email of the user
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Get password of the user
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set password of the user
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Get plain password of the user
     * @return string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * Set plain password of the user
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * Get first name of the user
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Set first name of the user
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * Get last name of the user
     * @return string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Set last name of the user
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * Get phone of the user
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Set phone of the user
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * Get indication whether the user is activated
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * Set indication whether the user is activated
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }


    /**
     * Returns the roles or permissions granted to the user for security.
     *
     * {@inheritdoc}
     */
    public function getRoles()
    {
        $roles = $this->roles;

        // guarantees that a user always has at least one role for security
        if (empty($roles)) {
            $roles[] = $this::ROLE_USER;
        }

        return array_unique($roles);
    }

    /**
     * Get roles of the user
     * @param $roles
     */
    public function setRoles($roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Get product orders of the user
     * @return ProductOrder[]
     */
    public function getProductOrders(): array
    {
        return $this->productOrders;
    }

    /**
     * Set product orders of the user
     * @param ProductOrder[] $productOrders
     */
    public function setProductOrders(array $productOrders): void
    {
        $this->productOrders = $productOrders;
    }

    /**
     * Add product order.
     * @param ProductOrder $productOrder
     */
    public function addProductOrder(ProductOrder $productOrder):void
    {
        $this->productOrders[] = $productOrder;
    }

    /**
     * Remove product order.
     * @param ProductOrder $productOrder
     */
    public function removeSubcategories(ProductOrder $productOrder): void
    {
        $this->productOrders->removeElement($productOrder);
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * {@inheritdoc}
     */
    public function getSalt(): ?string
    {
        // See "Do you need to use a Salt?" at https://symfony.com/doc/current/cookbook/security/entity_provider.html
        // we're using bcrypt in security.yml to encode the password, so
        // the salt value is built-in and you don't have to generate one

        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * {@inheritdoc}
     */
    public function eraseCredentials(): void
    {
        // if you had a plainPassword property, you'd nullify it here
        // $this->plainPassword = null;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        return serialize([$this->id, $this->username, $this->password]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        [$this->id, $this->username, $this->password] = unserialize($serialized, ['allowed_classes' => false]);
    }

    /**
     * Get String information of user.
     *
     * @return string Name of user
     */
    public function __toString(): string
    {
        return $this->getLastName().' '.$this->getFirstName();
    }

}
