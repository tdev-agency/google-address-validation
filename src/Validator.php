<?php

namespace TDevAgency\GoogleAddressValidation;

use TDevAgency\GoogleAddressValidation\Entities\ResultsEntity;
use TDevAgency\GoogleAddressValidation\Entities\SearchEntity;
use TDevAgency\GoogleAddressValidation\Entities\ValidatorEntity;
use TDevAgency\GoogleAddressValidation\Enums\GoogleResponseStatusEnum;
use TDevAgency\GoogleAddressValidation\Enums\ValidationStatusEnum;

class Validator
{
    public function __invoke(
        ResultsEntity $resultsEntity,
        SearchEntity $searchEntity
    ): ValidatorEntity {
        // if Google returns empty array
        if ($resultsEntity->getStatus() === GoogleResponseStatusEnum::ZERO_RESULTS() ||
            0 === \count($resultsEntity->getResults())
        ) {
            return ValidatorEntity::make(
                ValidationStatusEnum::ZERO_RESULT()
            );
        }
        if (1 === \count($resultsEntity->getResults())) {
            $addressEntity = $resultsEntity->getResults()[0];
            if (
                $this->compare($addressEntity->getStreetName(), $searchEntity->getStreetName()) &&
                $this->compare($addressEntity->getCity(), $searchEntity->getCity()) &&
                $this->compare($addressEntity->getStreetNumber(), $searchEntity->getHouseNumber())
            ) {
                return ValidatorEntity::make(
                    ValidationStatusEnum::SINGLE_RESULT(),
                    [],
                    $addressEntity
                );
            }
        }

        return ValidatorEntity::make(
            ValidationStatusEnum::MULTIPLE_RESULT(),
            $resultsEntity->getResults()
        );
    }

    private function compare($string1, $string2): bool
    {
        $string1 = rtrim($string1, '., ');
        $string2 = rtrim($string2, '., ');
        $res = abs(strcasecmp($string2, $string1));

        return $res <= 2;
    }
}
