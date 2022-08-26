<?php

namespace TDevAgency\GoogleAddressValidation\Enums;

use MyCLabs\Enum\Enum;

/*
 * @method static REQUEST_DENIED()
 * @method static ZERO_RESULTS()
 * @method static OK()
 */
final class GoogleResponseStatusEnum extends Enum
{
    private const OK = 'OK';
    private const ZERO_RESULTS = 'ZERO_RESULTS';
    private const OVER_DAILY_LIMIT = 'OVER_DAILY_LIMIT';
    private const OVER_QUERY_LIMIT = 'OVER_QUERY_LIMIT';
    private const REQUEST_DENIED = 'REQUEST_DENIED';
    private const INVALID_REQUEST = 'INVALID_REQUEST';
    private const UNKNOWN_ERROR = 'UNKNOWN_ERROR';
}
