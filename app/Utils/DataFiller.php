<?php declare(strict_types=1);

namespace App\Utils;

use Faker;

class DataFiller
{
    public static $fieldTypes = [

        // Base
        'randomDigit', 'randomDigitNotNull', 'randomLetter',
        // Lorem
        'word',
        // Person
        'name', 'firstName', 'firstNameMale', 'firstNameFemale', 'lastName',
        // Address
        'city', 'streetName', 'streetAddress', 'postcode', 'address',
        'country', 'latitude', 'longitude',
        // Company
        'company', 'jobTitle',
        // Text
        'realText',
        // DateTime
        'unixTime', 'dateTime', 'dateTimeAD', 'iso8601', 'date', 'time',
        'dateTimeBetween', 'dateTimeInInterval', 'dateTimeThisCentury',
        'dateTimeThisDecade', 'dateTimeThisYear', 'dateTimeThisMonth',
        'amPm', 'dayOfMonth', 'dayOfWeek', 'month', 'monthName',
        'year', 'century', 'timezone',
        // Color
        'hexcolor', 'rgbcolor', 'rgbColorAsArray', 'rgbCssColor',
        'safeColorName', 'colorName', 'hslColor', 'hslColorAsArray',
        // PhoneNumber
        'phoneNumber',
        // Internet
        'email', 'safeEmail', 'freeEmail', 'companyEmail', 'freeEmailDomain',
        'safeEmailDomain', 'userName', 'password', 'domainName', 'domainWord',
        'url', 'slug', 'ipv4', 'localIpv4', 'ipv6', 'macAddress',
        //UserAgent
        'userAgent', 'chrome', 'firefox', 'safari', 'opera', 'internetExplorer',
        // Payment
        'creditCardType', 'creditCardNumber', 'creditCardExpirationDate',
        'creditCardExpirationDateString', 'creditCardDetails',
        // File
        'fileExtension', 'mimeType',
        // uuid
        'uuid',
        // Barcode
        'ean13', 'ean8', 'isbn13', 'isbn10',
        // Miscellaneous
        'boolean', 'md5', 'sha1', 'sha256', 'locale', 'countryCode',
        'languageCode', 'currencyCode', 'emoji',
        // HtmlLorem
        'randomHtml',


    ];

    public static function make($locale, int $count, array $params): array
    {
        $locale = $locale ?? 'en_EN';
        $faker = Faker\Factory::create($locale);

        $out = [];

        for ($i = 1; $i <= $count; $i++) {
            $item = [];

            foreach ($params as $key=>$val) {
                $item[$key] = in_array($val, self::$fieldTypes) ? $faker->{$val} : $val;
            }

            $out[] = $item;
        }

        return $out;
    }

    /*
        template = [
          { "key": "boss", "val": "name", "count": 1},               // single key|value
          { "key": "total", "val": "3", "count": 1},                 // single key|value
          { "key": "data", "val": [                                  // nested template (if val is array)
            { "key": "name", "val": "name", "count": 1 },            //
            { "key": "phone", "val": "phoneNumber", "count": 1}      //
          ], "count": 3 }                                            //
        ]
    */
    public static function makeTemplate($locale, array $template): array
    {
        if (!is_array($template)) {
            throw new \Exception("Template Must Be The Array");
        }
        $locale = $locale ?? 'en_EN';
        $faker = Faker\Factory::create($locale);

        $out = [];
        foreach ($template as $val) {
            if (!is_array($val) || !array_key_exists('key', $val)) {
                throw new \Exception("Template Item Must Be The Array");
            }
            $keyName = $val['key'];
            $valValue = $val['val'];
            $cnt = array_key_exists('count', $val) && $val['count']>0 ? $val['count'] : 1;

            if (is_array($valValue)) {
                // nested template
                $items = [];
                for ($i = 1; $i <= $cnt; $i++) {
                    $items[] = self::makeTemplate($locale, $valValue);
                }
                $out[$keyName] = $items;
            } else {
                // simple value (need ignore count field)

                $out[$keyName] = in_array($valValue, self::$fieldTypes) ? $faker->{$valValue} : $valValue;
            }
        }
        return $out;
    }
}
