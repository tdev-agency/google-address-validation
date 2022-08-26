<?php

namespace TDevAgency\GoogleAddressValidation\Enums;

use MyCLabs\Enum\Enum;

/**
 * @see list of supported languages https://developers.google.com/maps/faq#languagesupport
 *
 * @method static RU()
 * @method static DE()
 * @method static EN()
 * @method static FR()
 * @method static ZH()
 * @method static ES()
 * @method static PT()
 */
class LanguageEnum extends Enum
{
    private const DE = 'de';
    private const RU = 'ru';
    private const ZH = 'zh';
    private const EN = 'en';
    private const FR = 'fr';
    private const PT = 'pt';
}
