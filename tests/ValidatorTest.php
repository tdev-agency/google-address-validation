<?php

namespace TDevAgency\GoogleAddressValidation\Tests;

use TDevAgency\GoogleAddressValidation\AddressValidator;
use TDevAgency\GoogleAddressValidation\Entities\SearchEntity;
use TDevAgency\GoogleAddressValidation\Enums\CountryEnum;
use TDevAgency\GoogleAddressValidation\Enums\LanguageEnum;
use TDevAgency\GoogleAddressValidation\Enums\ValidationStatusEnum;

class ValidatorTest extends TestCase
{
    /**
     * @var AddressValidator
     */
    private $addressValidation;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->addressValidation = new AddressValidator($_ENV['GOOGLE_API_KEY']);
    }

    public function testValidateZero(): void
    {
        $searchEntity = (new SearchEntity())->
            setHouseNumber('13')->
            setStreetName('Leipziger str')->
            setCity('Mountain View')->
            setCountry(CountryEnum::US());

        $result = $this->addressValidation->validate($searchEntity);

        $this->assertEquals(ValidationStatusEnum::ZERO_RESULT()->getValue(), $result->getStatus()->getValue());
        $this->assertCount(0, $result->getVariants());
        $this->assertNull($result->getAddress());
    }

    public function testValidateSingle(): void
    {
        $searchEntity = (new SearchEntity())->
            setHouseNumber('13')->
            setStreetName('leipziger st')->
            setCity('Berlin')->
            setCountry(CountryEnum::DE());

        $result = $this->addressValidation->validate($searchEntity);

        $this->assertEquals(ValidationStatusEnum::SINGLE_RESULT()->getValue(), $result->getStatus()->getValue());
        $this->assertCount(0, $result->getVariants());
        $this->assertNotNull($result->getAddress());
    }

    public function testValidateMultiple(): void
    {
        $searchEntity = (new SearchEntity())->
//            setHouseNumber('1')->
            setStreetName('251 FLORIDA ST')->
            setCity('BATON ROUGE')->
            setCountry(CountryEnum::US())->
        setLanguage(LanguageEnum::EN());

        $result = $this->addressValidation->validate($searchEntity);

        $this->assertEquals(ValidationStatusEnum::MULTIPLE_RESULT()->getValue(), $result->getStatus()->getValue());
        $this->assertNotCount(0, $result->getVariants());
        $this->assertNull($result->getAddress());
    }
}
