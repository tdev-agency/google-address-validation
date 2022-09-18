<?php

declare(strict_types=1);

namespace TDevAgency\GoogleAddressValidation\Entities;

use TDevAgency\GoogleAddressValidation\Enums\ValidationStatusEnum;

class ValidatorEntity
{
    /**
     * @var ValidationStatusEnum
     */
    protected $status;

    /** @var AddressEntity */
    protected $address = null;

    /* @var array<AddressEntity> */
    protected $variants = [];

    public static function make(
        ValidationStatusEnum $statusEnum,
        array $variants = [],
        ?AddressEntity $address = null
    ): self {
        $entity = new static();

        $entity->setStatus($statusEnum);
        $entity->setVariants($variants);
        $entity->setAddress($address);

        return $entity;
    }

    public function getAddress(): ?AddressEntity
    {
        return $this->address;
    }

    public function setAddress(?AddressEntity $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return AddressEntity[]
     */
    public function getVariants(): array
    {
        return $this->variants;
    }

    /**
     * @param AddressEntity[] $variants
     */
    public function setVariants(array $variants): self
    {
        $this->variants = $variants;

        return $this;
    }

    public function getStatus(): ValidationStatusEnum
    {
        return $this->status;
    }

    public function setStatus(ValidationStatusEnum $statusEnum): self
    {
        $this->status = $statusEnum;

        return $this;
    }
}
