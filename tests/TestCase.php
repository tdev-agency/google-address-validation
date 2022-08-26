<?php

namespace TDevAgency\GoogleAddressValidation\Tests;

use Dotenv\Dotenv;
use Faker\Factory;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        Dotenv::createImmutable(getcwd())->load();

        $this->faker = Factory::create();
    }
}
