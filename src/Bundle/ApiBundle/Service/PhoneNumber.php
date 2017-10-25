<?php

namespace PengYue\UserValidation\Bundle\ApiBundle\Service;

use libphonenumber\PhoneNumberUtil;

class PhoneNumber implements PhoneNumberInterface
{
    /**
     * The default phone number country code
     */
    const DEFAULT_COUNTRY_CODE = 'GB';

    /**
     * @var PhoneNumberUtil
     */
    private $phoneNumberUtil;

    /**
     * PhoneNumber constructor.
     */
    public function __construct()
    {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
    }

    /**
     * @param string $phoneNumber
     * @param string $countryCode
     *
     * @return bool
     */
    public function isValid($phoneNumber, $countryCode)
    {
        $phoneNumber = $this->phoneNumberUtil->parse($phoneNumber, $countryCode);
        return $this->phoneNumberUtil->isValidNumber($phoneNumber);
    }
}