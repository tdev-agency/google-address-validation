<?php

namespace TDevAgency\GoogleAddressValidation\Tests;

use ArgumentCountError;
use Dotenv\Dotenv;
use Faker\Factory;
use TDevAgency\GoogleAddressValidation\AddressValidator;
use TDevAgency\GoogleAddressValidation\Entities\SearchEntity;
use TDevAgency\GoogleAddressValidation\Entities\ValidatorEntity;
use TDevAgency\GoogleAddressValidation\Enums\CountryEnum;
use TDevAgency\GoogleAddressValidation\Exceptions\WrongApiKeyException;

class ApiKeyTest extends TestCase
{
    /**
     * @var SearchEntity
     */
    private $searchEntity;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        Dotenv::createImmutable(getcwd())->load();

        $this->searchEntity = (new SearchEntity())->
            setHouseNumber('1600')->
            setStreetName('Amphitheatre Parkway')->
            setCity('Mountain View')->
            setCountry(CountryEnum::US());
    }

    public function testEmptyApiKey(): void
    {
        $this->expectException(ArgumentCountError::class);
        $addressValidation = new AddressValidator();
    }

    public function testShortApiKey(): void
    {
        $this->expectException(WrongApiKeyException::class);
        $faker = Factory::create();
        $addressValidation = new AddressValidator($this->faker->text(6));
    }

    public function testGoogleKeyError(): void
    {
        $this->expectException(WrongApiKeyException::class);
        $addressValidation = new AddressValidator('AIzaSyDJeyi4QeuGY2-BR1R-mK5pY7d7IwFa');
        $addressValidation->validate($this->searchEntity);
    }

    public function testGoogleKeySuccessKey(): void
    {
        $addressValidation = new AddressValidator($_ENV['GOOGLE_API_KEY']);
        $result = $addressValidation->validate($this->searchEntity);

        $this->assertInstanceOf(ValidatorEntity::class, $result);
    }
}
