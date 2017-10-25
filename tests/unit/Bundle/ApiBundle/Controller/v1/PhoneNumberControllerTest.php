<?php

namespace PengYue\UserValidation\Bundle\ApiBundle\Controller\v1;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class PhoneNumberControllerTest extends TestCase
{
    public function testValidationPhoneNumberAction()
    {
        $request = Request::create('/api/v1/phone_number/validate');
        $request->request->add([
            'phone_number' => '07832348765',
            'country_code' => 'GB'
        ]);
        $response = JsonResponse::create(['valid' => true]);

        $controller = new PhoneNumberController();
        $this->assertEquals($response, $controller->validationPhoneNumberAction($request));
    }
}