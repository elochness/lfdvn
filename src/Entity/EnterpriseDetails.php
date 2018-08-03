<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * EnterpriseDetails
 *
 * @ORM\Table(name="enterprise_details")
 * @ORM\Entity
 */
class EnterpriseDetails
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=false)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=5, nullable=false)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=75, nullable=false)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=15, nullable=false)
     */
    private $telephone;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * get id
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * get name
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * set name
     * @param string $name
     * @return EnterpriseDetails
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * get address
     * @return null|string
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * set address
     * @param string $address
     * @return EnterpriseDetails
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * gte codepostal
     * @return null|string
     */
    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    /**
     * set codepostal
     * @param string $codePostal
     * @return EnterpriseDetails
     */
    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * get city
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * set city
     * @param string $city
     * @return EnterpriseDetails
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * get telephone
     * @return null|string
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * set telephone
     * @param string $telephone
     * @return EnterpriseDetails
     */
    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * get email
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * set email
     * @param null|string $email
     * @return EnterpriseDetails
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }


}
