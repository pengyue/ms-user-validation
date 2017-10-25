<?php

namespace PengYue\UserValidation\Bundle\ApiBundle\Service;

use PHPUnit\Framework\TestCase;

class PhoneNumberTest extends TestCase
{
    /**
     * @var PhoneNumber
     */
    private $phoneNumberService;

    public function setUp()
    {
        $this->phoneNumberService = new PhoneNumber();
    }

    /**
     * @dataProvider validPhoneNumberProvider
     */
    public function testItReturnTrueWhenPhoneNumberIsValid($phoneNumber, $countryCode)
    {
        $this->assertTrue($this->phoneNumberService->isValid($phoneNumber, $countryCode));
    }

    /**
     * @dataProvider invalidPhoneNumberProvider
     */
    public function testItReturnFalseWhenPhoneNumberIsInvalid($phoneNumber, $countryCode)
    {
        $this->assertFalse($this->phoneNumberService->isValid($phoneNumber, $countryCode));
    }

    public function validPhoneNumberProvider()
    {
        return [
            ['+447832348765', 'GB'],
            ['00447823456754', 'GB'],
            ['004407823456754', 'GB'],
            ['0044(0)7845671234', 'GB'],
            ['07534561234', 'GB'],
            ['02812345678', 'GB'],
            ['008613905334637', 'CN']
        ];
    }

    public function invalidPhoneNumberProvider()
    {
        return [
            ['+4478323487651', 'GB'],
            ['0044782345675', 'GB'],
            ['0044078234567543', 'GB'],
            ['0044(0)28034567897', 'GB'],
            ['02334561234', 'GB'],
            ['078345612341', 'GB'],
            ['00863905334637', 'CN']
        ];
    }
}