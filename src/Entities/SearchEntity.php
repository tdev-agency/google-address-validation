<?php

declare(strict_types=1);

namespace TDevAgency\GoogleAddressValidation\Entities;

use TDevAgency\GoogleAddressValidation\Enums\CountryEnum;
use TDevAgency\GoogleAddressValidation\Enums\LanguageEnum;
use TDevAgency\GoogleAddressValidation\Exceptions\SearchInputException;

class SearchEntity
{
    /* @var string */
    protected $houseNumber = '';

    /* @var string */
    protected $streetName = '';

    /* @var string */
    protected $city = '';

    /* @var string */
    protected $country = '';

    /* @var string */
    protected $region = '';

    /* @var string */
    protected $language = 'en';

    public function getHouseNumber(): string
    {
        return $this->houseNumber;
    }

    public function setHouseNumber(string $houseNumber): self
    {
        $this->houseNumber = $houseNumber;

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
     * @return CountryEnum
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(CountryEnum $country): self
    {
        $this->country = $country->getValue();

        return $this;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(LanguageEnum $language): self
    {
        $this->language = $language->getValue();

        return $this;
    }

    public function validateInputs(): void
    {
        if (empty($this->city)) {
            throw new SearchInputException('$city cannot be empty');
        }
        if (empty($this->streetName)) {
            throw new SearchInputException('$streetName cannot be empty');
        }
        if (empty($this->country)) {
            throw new SearchInputException('$country cannot be empty');
        }
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
