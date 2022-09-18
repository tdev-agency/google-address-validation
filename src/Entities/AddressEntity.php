<?php

declare(strict_types=1);

namespace TDevAgency\GoogleAddressValidation\Entities;

use TDevAgency\GoogleAddressValidation\Enums\CountryEnum;
use TDevAgency\GoogleAddressValidation\Enums\GoogleAddressTypeEnum;

class AddressEntity
{
    /* @var string */
    protected $streetNumber = '';

    /* @var string */
    protected $streetAddress = '';

    /* @var string */
    protected $postalCode = '';

    /* @var string */
    protected $streetName = '';

    /* @var string */
    protected $region = '';

    /* @var string */
    protected $city;

    /* @var CountryEnum */
    protected $country = '';

    public static function make(array $result): self
    {
        $entity = new static();

        /**
         * @var array{
         *     long_name: string,
         *     short_name: string,
         *     types: array<string>
         * } $component
         */
        foreach ($result['address_components'] as $component) {
            if (\in_array(GoogleAddressTypeEnum::STREET()->getValue(), $component['types'], true)) {
                $entity->setStreetName($component['short_name']);
                continue;
            }
            if (\in_array(GoogleAddressTypeEnum::HOUSE_NUMBER()->getValue(), $component['types'], true)) {
                $entity->setStreetNumber((string) $component['short_name']);
                continue;
            }
            if (\in_array(GoogleAddressTypeEnum::CITY()->getValue(), $component['types'], true)) {
                $entity->setCity((string) $component['short_name']);
                continue;
            }
            if (\in_array(GoogleAddressTypeEnum::STREET_ADDRESS()->getValue(), $component['types'], true)) {
                $entity->setCity((string) $component['short_name']);
                continue;
            }
            if (\in_array(GoogleAddressTypeEnum::COUNTRY()->getValue(), $component['types'], true)) {
                $entity->setCountry(CountryEnum::from($component['short_name']));
                continue;
            }
            if (\in_array(GoogleAddressTypeEnum::REGION()->getValue(), $component['types'], true)) {
                $entity->setRegion((string) $component['long_name']);
                continue;
            }
            if (\in_array(GoogleAddressTypeEnum::POST_CODE()->getValue(), $component['types'], true)) {
                $entity->setPostalCode((string) $component['short_name']);
                continue;
            }
        }

        return $entity;
    }

    public function getStreetNumber(): string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(string $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getStreetName(): string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): self
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|CountryEnum
     */
    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry(CountryEnum $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getStreetAddress(): string
    {
        return $this->streetAddress;
    }

    public function setStreetAddress(string $streetAddress): self
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getRegion(): string
    {
        return $this->region;
    }
}
