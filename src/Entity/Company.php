<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 *
 * @ORM\Table(name="company")
 * @ORM\Entity
 */
class Company
{
    /**
     * Company ID
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * Name of company
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * Address of company
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    private $address;

    /**
     * Postcode of of company
     * @var string
     *
     * @ORM\Column(name="postcode", type="string", length=5, nullable=false)
     */
    private $postcode;

    /**
     * City of company
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=75, nullable=false)
     */
    private $city;

    /**
     * Phone of company
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=15, nullable=false)
     */
    private $phone;

    /**
     * Email of company
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * Get Company ID
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set Company ID
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Get name of company
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name of company
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get address of company
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Set address of company
     * @param string $address
     */
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    /**
     * Get postcode of company
     * @return string
     */
    public function getPostcode(): string
    {
        return $this->postcode;
    }

    /**
     * Set postcode of company
     * @param string $postcode
     */
    public function setPostcode(string $postcode): void
    {
        $this->postcode = $postcode;
    }

    /**
     * Get city of company
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Set city of company
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * Get phone of company
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Set phone of company
     * @param string $phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * Get email of company
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set email of company
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

}
