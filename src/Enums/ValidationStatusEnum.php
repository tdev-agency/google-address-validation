<?php

declare(strict_types=1);

namespace TDevAgency\GoogleAddressValidation\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static ZERO_RESULT()
 * @method static SINGLE_RESULT()
 * @method static MULTIPLE_RESULT()
 */
final class ValidationStatusEnum extends Enum
{
    private const ZERO_RESULT = 'zero_result';
    private const SINGLE_RESULT = 'single_result';
    private const MULTIPLE_RESULT = 'multiple_result';
}
