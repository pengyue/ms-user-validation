<?php

namespace PengYue\UserValidation\Bundle\ApiBundle\Service;

interface PhoneNumberInterface
{
    /**
     * @param string $phoneNumber
     * @param string $countryCode
     *
     * @return bool
     */
    public function isValid($phoneNumber, $countryCode);
}