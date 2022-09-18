<?php

declare(strict_types=1);

namespace TDevAgency\GoogleAddressValidation\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static STREET_ADDRESS()
 * @method static STREET()
 * @method static HOUSE_NUMBER()
 * @method static POST_CODE()
 * @method static CITY()
 * @method static COUNTRY()
 * @method static PREMISE()
 * @method static REGION()
 */
final class GoogleAddressTypeEnum extends Enum
{
    private const STREET_ADDRESS = 'street_address';
    private const STREET = 'route';
    private const PREMISE = 'premise';
    private const HOUSE_NUMBER = 'street_number';
    private const POST_CODE = 'postal_code';
    private const CITY = 'locality';
    private const REGION = 'administrative_area_level_1';
    private const COUNTRY = 'country';
}
