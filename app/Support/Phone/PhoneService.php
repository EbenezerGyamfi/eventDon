<?php

namespace App\Support\Phone;

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberToCarrierMapper;
use libphonenumber\PhoneNumberUtil;

class PhoneService
{
    public static function formatPhoneNumber($number)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();
        $number = $phoneUtil->parse($number, 'GH');
        $number = $phoneUtil->format($number, PhoneNumberFormat::E164);

        return $number;
    }

    public function formatPhoneNumberWithoutPlusSign($number)
    {
        return substr(self::formatPhoneNumber($number), 1);
    }

    public static function getCarrier($number)
    {
        $carrierMapper = PhoneNumberToCarrierMapper::getInstance();
        $phoneUtil = PhoneNumberUtil::getInstance();

        $carrier = $carrierMapper->getNameForNumber(
            $phoneUtil->parse($number, 'GH'),
            'en'
        );

        $carrier = strtolower($carrier);

        return match ($carrier) {
            'airtel', 'tigo' => 'airteltigo',
            default => $carrier
        };
    }

    public static function getChannel($phoneNumber): string
    {
        return self::getCarrier($phoneNumber).'-gh';
    }
}
