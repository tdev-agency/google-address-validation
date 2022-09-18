<?php

declare(strict_types=1);

namespace TDevAgency\GoogleAddressValidation\Entities;

use TDevAgency\GoogleAddressValidation\Enums\GoogleAddressTypeEnum;
use TDevAgency\GoogleAddressValidation\Enums\GoogleResponseStatusEnum;

class ResultsEntity
{
    /* @var array<\TDevAgency\GoogleAddressValidation\Entities\AddressEntity> */
    protected $results = [];

    /**
     * @var GoogleResponseStatusEnum
     */
    protected $status;

    /**
     * @return AddressEntity[]
     */
    public function getResults(): array
    {
        return $this->results;
    }

    public function setResults(array $results): self
    {
        foreach ($results as $result) {
            if (\in_array(GoogleAddressTypeEnum::STREET_ADDRESS()->getValue(), $result['types'], false) ||
                \in_array(GoogleAddressTypeEnum::PREMISE()->getValue(), $result['types'], false)
            ) {
                $this->results[] = AddressEntity::make($result);
            }
        }

        return $this;
    }

    public function getStatus(): GoogleResponseStatusEnum
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = GoogleResponseStatusEnum::from($status);

        return $this;
    }
}
